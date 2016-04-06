<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }
    
    public function findQb()
    {
        $qb = $this->createQueryBuilder('u');
        
        return $qb;
    }
}
