<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Doctrine\ORM\Loader;

use Xidea\Component\User\Loader\UserLoaderInterface;

use Xidea\Bundle\UserBundle\Doctrine\ORM\Repository\UserRepository;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserLoader implements UserLoaderInterface
{
    /*
     * @var UserRepository
     */
    protected $userRepository;
    
    /**
     * Constructs a user loader.
     *
     * @param UserRepository The entity manager
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function loadAll()
    {
        return $this->userRepository->findAll();
    }

    /*
     * {@inheritdoc}
     */
    public function loadBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null)
    {
        return $this->userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    /*
     * {@inheritdoc}
     */
    public function loadOneBy(array $criteria, array $orderBy = array())
    {
        return $this->userRepository->findOneBy($criteria, $orderBy);
    }
    
    /**
     * {@inheritdoc}
     */
    public function loadOneByUsername($username)
    {
        return $this->userRepository->findOneByUsername($username);
    }
}
