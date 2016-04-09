<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 13:20
 */

namespace DevContest\DevContestApiBundle\Doctrine;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

/**
 * Doctrine naming stategy
 * @package DevContest\DevContestApiBundle\Doctrine
 */
class DevContestNamingStrategy extends UnderscoreNamingStrategy
{

    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        return 'dc_'.parent::classToTableName($className);
    }

    /**
     * {@inheritdoc}
     */
    public function propertyToColumnName($propertyName, $className = null)
    {
        return 'dc_'.parent::propertyToColumnName($propertyName, $className);
    }

    /**
     * {@inheritdoc}
     */
    public function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null)
    {
        return 'dc_'.parent::embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className, $embeddedClassName);
    }


    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName, $className = null)
    {
        return 'dc_'.parent::joinColumnName($propertyName, $className);
    }
}
