<?php

namespace DevContest\DevContestApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form Language
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class LanguageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('description' => 'Name'));
        $builder->add('logo', null, array('description' => 'Logo'));
    }
}
