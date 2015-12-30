<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Fixtures\Model;

use Xidea\Bundle\UserBundle\Model\AbstractAdvancedUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class User extends AbstractAdvancedUser
{
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->roles = new ArrayCollection();
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
}
