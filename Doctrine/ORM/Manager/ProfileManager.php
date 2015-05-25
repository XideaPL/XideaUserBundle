<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Doctrine\ORM\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use Doctrine\ORM\EntityManager;

use Xidea\Component\User\Manager\ProfileManagerInterface,
    Xidea\Component\User\Model\ProfileInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ProfileManager implements ProfileManagerInterface
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
     * Constructs a profile manager.
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
    public function save(ProfileInterface $profile)
    {
        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile->getId();
    }
    
    public function update(ProfileInterface $profile)
    {  
        $this->updatePassword($profile);
        
        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile->getId();
    }
    
    public function updatePassword(ProfileInterface $profile)
    {
        if (0 !== strlen($password = $profile->getPlainPassword())) {
            $encoder = $this->encoderFactory->getEncoder($profile);
            $profile->setPassword($encoder->encodePassword($password, $profile->getSalt()));
            $profile->eraseCredentials();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProfileInterface $profile)
    {
        $this->entityManager->remove($profile);
    }
}
