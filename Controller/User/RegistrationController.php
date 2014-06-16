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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Xidea\Bundle\UserBundle\Model\UserFactoryInterface;
use Xidea\Bundle\UserBundle\Model\Manager\UserManagerInterface;
use Xidea\Bundle\UserBundle\Form\Factory\FormFactoryInterface;
use Xidea\Bundle\UserBundle\UserEvents;
use Xidea\Bundle\UserBundle\Event\GetResponseEvent;
use Xidea\Bundle\UserBundle\Event\GetUserResponseEvent;
use Xidea\Bundle\UserBundle\Event\FilterUserResponseEvent;
use Xidea\Bundle\UserBundle\Event\FormEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class RegistrationController
{
    /*
     * @var UserFactoryInterface
     */
    protected $userFactory;

    /*
     * @var UserManagerInterface
     */
    protected $userManager;

    /*
     * @var FormFactoryInterface
     */
    protected $formFactory;

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

    public function __construct(UserFactoryInterface $userFactory, UserManagerInterface $userManager, FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher, EngineInterface $templating, TranslatorInterface $translator, array $options = array())
    {
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->templating = $templating;
        $this->translator = $translator;

        $this->options = array(
            'routes' => array(
                'user_view' => 'xidea_user_profile_view'
            )
        );
    }

    public function registerAction(Request $request)
    {
        $event = new GetResponseEvent($request);
        $this->dispatcher->dispatch(UserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $user = $this->userFactory->createUser();

        $event = new GetUserResponseEvent($user, $request);
        $this->dispatcher->dispatch(UserEvents::PRE_REGISTRATION, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $this->dispatcher->dispatch(UserEvents::REGISTRATION_FORM_VALID, $event);

                if ($this->manager->save($user)) {
                    $event = new GetUserResponseEvent($user, $request);
                    $dispatcher->dispatch(UserEvents::REGISTRATION_SUCCESS, $event);

                    if (null === $response = $event->getResponse()) {
                        $url = $this->container->get('router')->generate($this->options['routes']['user_view'], array(
                            'id' => $user->getId()
                        ));
                        $response = new RedirectResponse($url);
                    }

                    $dispatcher->dispatch(UserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                    return $response;
                }
            }
        }

        return $this->templating->renderResponse('XideaUserBundle:User/Registration:register.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function registerFormAction()
    {
        $form = $this->formFactory->createForm();

        return $this->getTemplating()->renderResponse('XideaUserBundle:User/Registration:register_form.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function confirmedAction()
    {
        return new RedirectResponse($this->container->get('router')->generate('_welcome'));
    }

}
