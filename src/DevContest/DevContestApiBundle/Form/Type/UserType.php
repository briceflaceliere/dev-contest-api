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

/**
 * Form User
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nickname', null, array('description' => 'Nickname'));
    }
}
