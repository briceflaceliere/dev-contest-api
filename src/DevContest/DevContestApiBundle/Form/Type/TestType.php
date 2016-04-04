<?php

namespace DevContest\DevContestApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestType extends AbstractType
{
	public function getName()
    {
        return 'test';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('title', null, array('description' => 'Title'));
    	$builder->add('description', null, array('description' => 'Description'));
    }
}