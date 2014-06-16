<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of RegistrationType
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class RegistrationType extends AbstractType
{

    protected $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', null, array(
                    'label' => 'user_registration.form.username'
                ))
                ->add('email', 'email', array(
                    'label' => 'user_registration.form.email'
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'first_options' => array('label' => 'user_registration.form.password'),
                    'second_options' => array('label' => 'user_registration.form.password_confirmation'),
                    'invalid_message' => 'user_registration.error.password.mismatch',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'registration',
        ));
    }

    public function getName()
    {
        return 'xidea_user_registration';
    }

}
