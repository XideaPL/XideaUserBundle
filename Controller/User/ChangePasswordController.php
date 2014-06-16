<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Xidea\Bundle\UserBundle\Model\Manager\UserManagerInterface;
use Xidea\Bundle\UserBundle\Form\Factory\FormFactoryInterface;
use Xidea\Bundle\UserBundle\UserEvents;
use Xidea\Bundle\UserBundle\Event\GetResponseEvent;
use Xidea\Bundle\UserBundle\Event\GetUserResponseEvent;
use Xidea\Bundle\UserBundle\Event\FilterUserResponseEvent;
use Xidea\Bundle\UserBundle\Event\FormEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Xidea\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ChangePasswordController
{
    /*
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /*
     * @var UserManagerInterface
     */
    protected $userManager;

    /*
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /*
     * @var RouterInterface
     */
    protected $router;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /*
     * @var EngineInterface
     */
    protected $templating;

    /*
     * @var TranslatorInterface
     */
    protected $translator;

    /*
     * @var array
     */
    protected $options;

    public function __construct(SecurityContextInterface $securityContext, UserManagerInterface $userManager, FormFactoryInterface $formFactory, RouterInterface $router, EventDispatcherInterface $eventDispatcher, EngineInterface $templating, TranslatorInterface $translator, array $options = array())
    {
        $this->securityContext = $securityContext;
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
        $this->templating = $templating;
        $this->translator = $translator;

        $this->options = array(
            'routes' => array(
                'user_profile' => 'xidea_user_profile'
            )
        );
    }

    public function changePasswordAction(Request $request)
    {
        $user = $this->securityContext->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $event = new GetUserResponseEvent($user, $request);
        $this->eventDispatcher->dispatch(UserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(UserEvents::CHANGE_PASSWORD_FORM_VALID, $event);

                if ($this->userManager->update($user)) {
                    $event = new GetUserResponseEvent($user, $request);
                    $this->eventDispatcher->dispatch(UserEvents::CHANGE_PASSWORD_SUCCESS, $event);

                    if (null === $response = $event->getResponse()) {
                        $url = $this->router->generate($this->options['routes']['user_profile']);
                        $response = new RedirectResponse($url);
                    }

                    $this->eventDispatcher->dispatch(UserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                    return $response;
                }
            }
        }

        return $this->templating->renderResponse('XideaUserBundle:User/ChangePassword:change_password.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
