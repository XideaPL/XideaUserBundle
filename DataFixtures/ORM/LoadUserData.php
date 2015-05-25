<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $this->loadData();
        
        $encoderFactory = $this->container->get('security.encoder_factory');
        $userManager = $this->container->get('xidea_user.user.manager');
        
        foreach($data as $user) {
            $encoder = $encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            
            $userManager->save($user);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
    
    /**
     * Returns a user factory.
     * 
     * @return \Xidea\Component\Base\Model\ModelFactory The user factory
     */
    protected function getUserFactory()
    {
        return $this->container->get('xidea_user.user.factory');
    }
    
    /**
     * Returns a user factory.
     * 
     * @return \Xidea\Component\Base\Model\ModelFactory The user factory
     */
    protected function getProfileFactory()
    {
        return $this->container->get('xidea_user.profile.factory');
    }
    
    /**
     * Returns a data.
     * 
     * @return array The data
     */
    protected function loadData()
    {
        $userFactory = $this->getUserFactory();
        $profileFactory = $this->getProfileFactory();

        $admin = $userFactory->create();
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        if($admin instanceof \Xidea\Component\User\Model\AdvancedUserInterface)
        {
            $profile = $profileFactory->create();
            $profile->setName('Admin');
            $admin->setEmail('artur.pszczolka@xidea.pl');
            $admin->setIsEnabled(true);
            $admin->setProfile($profile);
        }
        $admin->addRole('ROLE_SUPER_ADMIN');
        $this->setReference('user-admin', $admin);
        
        $johndoe = $userFactory->create();
        $johndoe->setUsername('johndoe');
        $johndoe->setPlainPassword('johndoe');
        if($johndoe instanceof \Xidea\Component\User\Model\AdvancedUserInterface)
        {
            $profile = $profileFactory->create();
            $profile->setName('John Doe');
            $johndoe->setEmail('test@xidea.pl');
            $johndoe->setIsEnabled(true);
            $johndoe->setProfile($profile);
        }
        $johndoe->addRole('ROLE_USER');
        $this->setReference('user-johndoe', $johndoe);
        
        $janedoe = $userFactory->create();
        $janedoe->setUsername('janedoe');
        $janedoe->setPlainPassword('janedoe');
        if($janedoe instanceof \Xidea\Component\User\Model\AdvancedUserInterface)
        {
            $profile = $profileFactory->create();
            $profile->setName('Jane Doe');
            $janedoe->setEmail('test1@xidea.pl');
            $janedoe->setIsEnabled(true);
            $janedoe->setProfile($profile);
        }
        $janedoe->addRole('ROLE_USER');
        $this->setReference('user-janedoe', $janedoe);
        
        return array(
            $admin,
            $johndoe,
            $janedoe
        );
    }
 
}
