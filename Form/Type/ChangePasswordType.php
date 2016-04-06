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
 * Description of ChangePasswordType
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ChangePasswordType extends AbstractType
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
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'label' => 'user.password',
                        'translation_domain' => 'form'
                    ),
                    'second_options' => array(
                        'label' => 'user.password_confirmation',
                        'translation_domain' => 'form'
                    ),
                    'invalid_message' => 'user.password.mismatch',
                ))
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class,
            'intention' => 'change_password',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'xidea_user_change_password';
    }

}
