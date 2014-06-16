<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface as SfAdvancedUserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
interface AdvancedUserInterface extends UserInterface, SfAdvancedUserInterface
{
    /**
     * Sets the email.
     * 
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Gets the email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * @param boolean $boolean
     *
     * @return self
     */
    public function setIsEnabled($isEnabled);

    /**
     * Gets the confirmation token.
     *
     * @return string
     */
    public function getConfirmationToken();

    /**
     * Sets the confirmation token
     *
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null);

    /**
     * @return datetime
     */
    public function getCreatedAt();

    /**
     * @param datetime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null);

    /**
     * @return datetime
     */
    public function getUpdatedAt();

    /**
     * Sets the last login time
     *
     * @param \DateTime $lastLogin
     *
     * @return self
     */
    public function setLastLogin(\DateTime $lastLogin = null);
}
