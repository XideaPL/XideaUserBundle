<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model\Manager;

use Xidea\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
interface UserManagerInterface
{
    /**
     * Saves a user.
     * 
     * @param UserInterface $user
     */
    function save(UserInterface $user);

    /**
     * Updates a user.
     * 
     * @param UserInterface $user
     */
    function update(UserInterface $user);
    
    /**
     * Updates a user password.
     * 
     * @param UserInterface $user
     */
    function updatePassword(UserInterface $user);

    /**
     * Deletes a user.
     * 
     * @param UserInterface $user
     */
    function delete(UserInterface $user);
}
