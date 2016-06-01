<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 31/03/16
 * Time: 13:18
 */

namespace DevContest\DevContestApiBundle\Repository;

use \Doctrine\ORM\EntityRepository;

/**
 * Class AbstractEntityRepository
 *
 * @package DevContest\DevContestApiBundle\Repository
 */
abstract class AbstractEntityRepository extends EntityRepository
{
    /**
     * Get findAll query builder
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function qFindAll()
    {
        return $this->createQueryBuilder('u');
    }

    /**
     * Get findBy query builder
     *
     * @param array $wheres
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function qFindBy(array $wheres = [])
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('1 = 1');
        foreach ($wheres as $k => $v) {
            $qb->andWhere($qb->expr()->eq('u.' . $k, ':' . $k));
        }
        $qb->setParameters($wheres);
        return $qb;
    }
}
