<?php

namespace Xidea\Bundle\UserBundle\Controller;

use Xidea\Bundle\BaseBundle\Controller\AbstractController;
use Xidea\Base\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /*
     * @var AuthenticationUtils
     */
    protected $authenticationUtils;
    
    public function __construct(ConfigurationInterface $configuration, AuthenticationUtils $authenticationUtils)
    {
        parent::__construct($configuration);
        
        $this->authenticationUtils = $authenticationUtils;
    }
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('login', array(
                'last_username' => $lastUsername,
                'error'         => $error,
        ));
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function loginFormAction(Request $request)
    {
        return $this->render('login_form', array(
                'last_username' => '',
                'error'         => '',
        ));
    }
}
