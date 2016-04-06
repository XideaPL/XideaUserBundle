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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RegistrationType
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserType extends AbstractType
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
                    'label' => 'user_create.form.username'
                ))
//                ->add('email', 'email', array(
//                    'label' => 'user_create.form.email'
//                ))
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'user_create.form.password'),
                    'second_options' => array('label' => 'user_create.form.password_confirmation'),
                    'invalid_message' => 'user_create.error.password.mismatch',
                ))
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'xidea_user';
    }

}
