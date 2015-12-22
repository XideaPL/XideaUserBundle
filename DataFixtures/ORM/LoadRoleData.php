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
class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        
        $roleManager = $this->container->get('xidea_user.role.manager');
        
        foreach($data as $role) {
            $roleManager->save($role);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * Returns a role factory.
     * 
     * @return \Xidea\Base\Model\Factory\DefaultFactory The role factory
     */
    protected function getRoleFactory()
    {
        return $this->container->get('xidea_user.role.factory');
    }
    
    /**
     * Returns a data.
     * 
     * @return array The data
     */
    protected function loadData()
    {
        $roleFactory = $this->getRoleFactory();
        
        $userRole = $roleFactory->create();
        $userRole->setName('ROLE_USER');
        $this->setReference('user-role-user', $userRole);
        $adminRole = $roleFactory->create();
        $adminRole->setName('ROLE_ADMIN');
        $this->setReference('user-role-admin', $adminRole);
        
        return array(
            $userRole,
            $adminRole
        );
    }
 
}
