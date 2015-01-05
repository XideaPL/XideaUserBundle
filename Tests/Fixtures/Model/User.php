<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Fixtures\Model;

use Xidea\Bundle\UserBundle\Model\AbstractUser;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class User extends AbstractUser
{
    public function setId($id)
    {
        $this->id = $id;
    }
}
