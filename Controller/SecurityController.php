<?php

namespace Xidea\Bundle\UserBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class SecurityController
{
    /*
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
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

        return $this->templating->renderResponse(
            'XideaUserBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    public function loginFormAction()
    {
        return $this->templating->renderResponse(
            'XideaUserBundle:Security:login_form.html.twig',
            array(
                'last_username' => '',
                'error'         => '',
            )
        );
    }
}
