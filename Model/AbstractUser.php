<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Xidea\User\AbstractUser as BaseAbstractUser;

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
