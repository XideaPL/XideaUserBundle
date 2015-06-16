<?php

namespace Xidea\Bundle\UserBundle\Controller;

use Xidea\Bundle\BaseBundle\Controller\AbstractController,
    Xidea\Bundle\BaseBundle\ConfigurationInterface;
use Symfony\Component\Security\Core\SecurityContext,
    Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /*
     * @var string
     */
    protected $loginTemplate = 'login';
    
    /*
     * @var string
     */
    protected $loginFormTemplate = 'login_form';
    
    /**
     * 
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        parent::__construct($configuration);
    }
    
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->onLoginView(array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
        ), $request);
    }
    
    public function loginFormAction(Request $request)
    {
        return $this->onLoginFormView(array(
                'last_username' => '',
                'error'         => '',
        ), $request);
    }
    
    protected function onLoginView(array $parameters = array(), Request $request = null)
    {
        return $this->render($this->loginTemplate, $parameters);
    }

    protected function onLoginFormView(array $parameters = array(), Request $request = null)
    {
        return $this->render($this->loginFormTemplate, $parameters);
    }
}
