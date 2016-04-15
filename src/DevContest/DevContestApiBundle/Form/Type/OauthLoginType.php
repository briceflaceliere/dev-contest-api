<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 02/04/16
 * Time: 13:36
 */

namespace DevContest\DevContestApiBundle\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form User
 * @package DevContest\DevContestApiBundle\Form\Type
 */
class OauthLoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'oauth_login';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('provider', null, ['description' => 'Oauth provider'])
                ->add('accessToken', null, ['description' => 'Oauth access token']);
    }
}
