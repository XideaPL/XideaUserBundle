<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Entity\Loader;

use Doctrine\ORM\EntityManager;
use Xidea\Bundle\UserBundle\Model\Loader\UserLoaderInterface;
use Xidea\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserLoader implements UserLoaderInterface
{
    /*
     * @var string
     */
    protected $class;

    /*
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * Constructs a user loader.
     *
     * @param string $class The class
     * @param EntityManager The entity manager
     */
    public function __construct($class, EntityManager $entityManager)
    {
        $this->class = $class;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function load($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function loadAll()
    {
        return $this->getRepository()->findAll();
    }

    /*
     * {@inheritdoc}
     */

    public function loadBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    protected function getRepository()
    {
        return $this->entityManager->getRepository($this->class);
    }

}
