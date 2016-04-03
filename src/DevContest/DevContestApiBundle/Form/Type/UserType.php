<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 02/04/16
 * Time: 13:36
 */

namespace DevContest\DevContestApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function getName()
    {
        return 'user';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nickname', null, array('description' => 'Nickname'));
    }
}