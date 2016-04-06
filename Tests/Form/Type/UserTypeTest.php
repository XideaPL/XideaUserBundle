<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Form\Type;

use Xidea\Bundle\UserBundle\Form\Type\UserType,
    Xidea\Bundle\UserBundle\Tests\Fixtures\Model\User;

use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Form\PreloadedExtension;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'username' => 'admin',
            'plainPassword' => array(
                'first' => 'password',
                'second' => 'password1'
            )
        );
        
        $object = new User();

        $form = $this->factory->create(UserType::class, $object);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
    
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtension(
                new FormTypeValidatorExtension(
                    $validator
                )
            )
            ->addTypeGuesser(
                $this->getMockBuilder(
                    'Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser'
                )
                    ->disableOriginalConstructor()
                    ->getMock()
            )
            ->getFormFactory();

        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }
    
    protected function getExtensions()
    {
        $type = new UserType(User::class);

        return array(
            new PreloadedExtension(array($type), array()),
        );
    }
}