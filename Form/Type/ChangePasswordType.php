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
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'change_password',
        ));
    }

    public function getName()
    {
        return 'xidea_user_change_password';
    }

}
