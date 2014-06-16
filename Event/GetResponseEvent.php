<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class GetResponseEvent extends Event
{
    
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Response
     */
    protected $response;

    /**
     * Constructs an event.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

}
