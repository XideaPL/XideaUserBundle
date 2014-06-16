<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model;

/**
 */
abstract class AbstractUser
{
    /*
     * @var int
     */
    protected $id;
    
    /*
     * @var string
     */
    protected $username;

    /*
     * @var string
     */
    protected $salt;
    
    /*
     * @var string
     */
    protected $password;
    
    /*
     * @var string
     */
    protected $plainPassword;
    
    /*
     * @var array
     */
    protected $roles;
    
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->roles = array('ROLE_USER');
    }
    
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    
    /**
     * @inheritDoc
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    /**
     * @inheritDoc
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    
    /**
     * @inheritDoc
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }
    
    /**
     * @inheritDoc
     */
    public function removeRole($role)
    {
        unset($this->roles[$role]);
    }
    
    /**
     * @inheritDoc
     */
    public function hasRole($role)
    {
        return isset($this->roles[$role]);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
