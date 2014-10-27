<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Entity\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use Doctrine\ORM\EntityManager;

use Xidea\Component\User\Model\Manager\UserManagerInterface,
    Xidea\Component\User\Model\UserInterface;

use Xidea\Bundle\UserBundle\UserEvents;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserManager implements UserManagerInterface
{
    /*
     * @var EntityManagerInterface
     */
    protected $entityManager;
    
    /*
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructs a user manager.
     *
     * @param string $class The class
     * @param EntityManager The entity manager
     */
    public function __construct(EntityManager $entityManager, EncoderFactoryInterface $encoderFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save(UserInterface $user)
    {
        $this->eventDispatcher->dispatch(UserEvents::PRE_SAVE, new UserEvent($user));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $this->eventDispatcher->dispatch(UserEvents::POST_SAVE, new UserEvent($user));

        return $user->getId();
    }
    
    public function update(UserInterface $user)
    {  
        $this->updatePassword($user);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
    }
    
    public function updatePassword(UserInterface $user)
    {  
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(UserInterface $user)
    {
        $this->entityManager->remove($user);
    }
}
