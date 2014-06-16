<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
abstract class AbstractAdvancedUser extends AbstractUser
{
    /*
     * @var string
     */
    protected $email;

    /*
     * @var boolean
     */
    protected $isEnabled;
    
    /*
     * @var string
     */
    protected $confirmationToken;
    
    /*
     * @var datetime
     */
    protected $createdAt;
    
    /*
     * @var datetime
     */
    protected $updatedAt;
    
    /*
     * @var datetime
     */
    protected $lastLogin;

    public function __construct()
    {
        $this->isEnabled = true;
        parent::__construct();
    }
    
    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @inheritDoc
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }
    
    /**
     * @inheritDoc
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }
    
    /**
     * @inheritDoc
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }
    
    /**
     * @inheritDoc
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }
    
    /**
     * @inheritDoc
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @inheritDoc
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @inheritDoc
     */
    public function setLastLogin(\DateTime $lastLogin = null)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @inheritDoc
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
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
