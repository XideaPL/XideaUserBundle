<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as SfUserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
interface UserInterface extends SfUserInterface, \Serializable
{

    /**
     * Returns a user id.
     * 
     * @return string The user id
     */
    public function getId();

    /**
     * Sets the username.
     * 
     * @param string $username
     */
    public function setUsername($username);

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword();

    /**
     * Sets the plain password.
     *
     * @param string $password
     */
    public function setPlainPassword($password);

    /**
     * Sets the password.
     * 
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role);

    /**
     * Sets the roles of the user.
     *
     * This overwrites any previous roles.
     *
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles);

    /**
     * Adds a role to the user.
     *
     * @param string $role
     *
     * @return self
     */
    public function addRole($role);

    /**
     * Removes a role to the user.
     *
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role);
}
