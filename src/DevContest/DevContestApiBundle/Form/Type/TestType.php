<?php

namespace DevContest\DevContestApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * From Test
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class TestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array('description' => 'Title'));
        $builder->add('description', null, array('description' => 'Description'));
    }
}
