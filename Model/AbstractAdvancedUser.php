<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

use Xidea\Component\User\Model\AbstractAdvancedUser as BaseAbstractAdvancedUser;
/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
abstract class AbstractAdvancedUser extends BaseAbstractAdvancedUser implements AdvancedUserInterface
{
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * @inheritDoc
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
}
