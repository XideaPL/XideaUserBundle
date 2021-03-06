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

use Xidea\User\Profile\ManagerInterface,
    Xidea\User\ProfileInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ProfileManager implements ManagerInterface
{
    /*
     * @var EntityManager
     */
    protected $entityManager;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructs a profile manager.
     *
     * @param EntityManager $entityManager The entity manager
     * @param EventDispatcherInterface $eventDispatcher The event dispatcher
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ProfileInterface $profile)
    {
        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile->getId();
    }
    
    /**
     * {@inheritdoc}
     */    
    public function update(ProfileInterface $profile)
    {  
        $this->updatePassword($profile);
        
        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProfileInterface $profile)
    {
        $this->entityManager->remove($profile);
    }
}
