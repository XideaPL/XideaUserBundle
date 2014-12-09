<?php

namespace Xidea\Bundle\UserBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext,
    Symfony\Component\HttpFoundation\Request;

use Xidea\Component\Template\Manager\TemplateManagerInterface;

class SecurityController
{
    /*
     * @var TemplateManagerInterface
     */
    protected $templateManager;

    public function __construct(TemplateManagerInterface $templateManager)
    {
        $this->templateManager = $templateManager;
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

        return $this->templateManager->render(
            'user_login',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    public function loginFormAction()
    {
        return $this->templateManager->render(
            'user_login_form',
            array(
                'last_username' => '',
                'error'         => '',
            )
        );
    }
}
