<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Doctrine\ORM\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\ORM\EntityManager;

use Xidea\User\Role\ManagerInterface,
    Xidea\User\RoleInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class RoleManager implements ManagerInterface
{
    /*
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructs a role manager.
     *
     * @param EntityManager $entityManager The entity manager
     * @param EventDispatcherInterface $eventDispatcher The entity manager
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save(RoleInterface $role)
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $role->getId();
    }
    
    /**
     * {@inheritdoc}
     */    
    public function update(RoleInterface $role)
    {  
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $role->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RoleInterface $role)
    {
        $this->entityManager->remove($role);
    }
}
