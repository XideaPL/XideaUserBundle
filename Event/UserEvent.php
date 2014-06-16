<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Xidea\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserEvent extends Event
{

    /**
     * @var UserInterface
     */
    protected $user;
    
    /**
     * @var Request
     */
    protected $request;

    /**
     * Constructs an event.
     *
     * @param UserInterface $user The user
     */
    public function __construct(UserInterface $user, Request $request = null)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}
