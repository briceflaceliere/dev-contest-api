<?php

namespace DevContest\DevContestApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form ContestStep
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class ContestStepType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'step';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contest')
            ->add('title')
            ->add('description')
            ->add('statement')
            ->add('previousContestStep')
        ;
    }
}
