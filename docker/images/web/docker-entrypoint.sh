#!/bin/bash

# set env vars to defaults
APACHE_RUN_USER=www-data
APACHE_RUN_GROUP=www-data

echo "[START] DOCKER_RUN_UID:$DOCKER_RUN_UID DOCKER_RUN_GID:$DOCKER_RUN_GID"

if [ -n "$DOCKER_RUN_GID" ]; then
    MAP_GROUP=$(getent group $DOCKER_RUN_GID | cut -d: -f1)
    echo "[GROUP] MAP_GROUP: $MAP_GROUP"
     # Create new group using target GID and add apache run user
    if [ -z $MAP_GROUP ]; then
        MAP_GROUP="dkrfakegroup"
        echo "[GROUP] groupadd: -g $DOCKER_RUN_GID $MAP_GROUP"
        groupadd -g $DOCKER_RUN_GID $MAP_GROUP
    fi
    APACHE_RUN_GROUP=${MAP_GROUP}
fi

if [ -n "$DOCKER_RUN_UID" ]; then
    MAP_USER=$(getent passwd $DOCKER_RUN_UID | cut -d: -f1)
    echo "[USER] MAP_USER: $MAP_USER"
    if [ -z $MAP_USER ]; then
        # UID does not exist, create a user
        MAP_USER="dkrfakeuser"
        echo "[USER] useradd -m -s /bin/bash -u $DOCKER_RUN_UID -g $DOCKER_RUN_GID $MAP_USER"
        useradd -m -s /bin/bash -u $DOCKER_RUN_UID -g $DOCKER_RUN_GID $MAP_USER
        echo "[USER] usermod -a -G www-data $MAP_USER"
        usermod -a -G www-data $MAP_USER
    fi
    APACHE_RUN_USER=${MAP_USER}
fi

# check if APACHE_RUN_USER is in group APACHE_RUN_GROUP
APACHE_USERS_IN_GROUP=$(getent group $APACHE_RUN_GROUP|cut -d: -f4)
MAP_USER_IN_GROUP=""
if [ -n "$APACHE_USERS_IN_GROUP" ]; then
    MAP_USER_IN_GROUP=$(echo $APACHE_USERS_IN_GROUP|grep $APACHE_RUN_USER)
fi

if [ -z "$MAP_USER_IN_GROUP" ]; then
    echo "[FINAL] usermod: -a -G $APACHE_RUN_GROUP $APACHE_RUN_USER"
    usermod -a -G $APACHE_RUN_GROUP $APACHE_RUN_USER
fi

if [ "$1" = 'httpd' ]; then
    echo "Run apache as ${APACHE_RUN_USER}:${APACHE_RUN_GROUP} :-)"
	export APACHE_RUN_USER
    export APACHE_RUN_GROUP
	exec apache2-foreground
fi
echo "[END] gosu involved $APACHE_RUN_USER:$APACHE_RUN_GROUP"

exec gosu $APACHE_RUN_USER:$APACHE_RUN_GROUP "$@"
