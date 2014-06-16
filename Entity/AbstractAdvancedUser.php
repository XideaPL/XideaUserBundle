<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Entity;

use Xidea\Bundle\UserBundle\Model\AbstractAdvancedUser as BaseAbstractAdvancedUser;
use Xidea\Bundle\UserBundle\Model\AdvancedUserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
abstract class AbstractAdvancedUser extends BaseAbstractAdvancedUser implements AdvancedUserInterface
{    
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
