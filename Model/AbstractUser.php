<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

use Xidea\User\AbstractUser as BaseAbstractUser;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 */
abstract class AbstractUser extends BaseAbstractUser implements UserInterface
{    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}
