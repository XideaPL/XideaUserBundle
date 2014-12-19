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
        $userManager = $this->container->get('xidea_user.user_manager');
        
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
     * @return \Xidea\Bundle\UserBundle\Model\UserFactory The user factory
     */
    protected function getUserFactory()
    {
        return $this->container->get('xidea_user.user_factory');
    }
    
    /**
     * Returns a data.
     * 
     * @return array The data
     */
    protected function loadData()
    {
        $userFactory = $this->getUserFactory();

        $user1 = $userFactory->create();
        $user1->setUsername('admin');
        $user1->setPlainPassword('admin');
        if($user1 instanceof \Xidea\Component\User\Model\AdvancedUserInterface)
        {
            $user1->setEmail('artur.pszczolka@xidea.pl');
            $user1->setIsEnabled(true);
        }
        $user1->addRole('ROLE_SUPER_ADMIN');
        //$this->addReference('user-premium', $premium);
        
        return array(
            $user1
        );
    }
 
}
