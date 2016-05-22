<?php

namespace DevContest\DevContestApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form Contest
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class ContestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contest';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('description' => 'Name'));
        $builder->add('logo', null, array('description' => 'Logo'));
        $builder->add('startTs', DateTimeType::class, array('description' => 'Start ts'));
        $builder->add('endTs', DateTimeType::class, array('description' => 'End ts'));
    }
}
