<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Xidea\Component\User\Builder\UserDirectorInterface,
    Xidea\Component\User\Manager\UserManagerInterface,
    Xidea\Component\Url\Manager\UrlManagerInterface,
    Xidea\Component\Template\Manager\TemplateManagerInterface,
    Xidea\Bundle\UserBundle\Form\Handler\UserFormHandlerInterface,
    Xidea\Bundle\UserBundle\UserEvents,
    Xidea\Bundle\UserBundle\Event\GetResponseEvent,
    Xidea\Bundle\UserBundle\Event\GetUserResponseEvent,
    Xidea\Bundle\UserBundle\Event\FilterUserResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
abstract class AbstractCreateController
{
    /*
     * @var UserDirectorInterface
     */
    protected $userDirector;

    /*
     * @var UserManagerInterface
     */
    protected $userManager;

    /*
     * @var UserFormHandlerInterface
     */
    protected $formHandler;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /*
     * @var UrlManagerInterface
     */
    protected $urlManager;

    /*
     * @var TemplateManagerInterface
     */
    protected $templateManager;

    public function __construct(UserDirectorInterface $userDirector, UserManagerInterface $userManager, UserFormHandlerInterface $formHandler, EventDispatcherInterface $eventDispatcher, UrlManagerInterface $urlManager, TemplateManagerInterface $templateManager)
    {
        $this->userDirector = $userDirector;
        $this->userManager = $userManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->formHandler = $formHandler;
        $this->urlManager = $urlManager;
        $this->templateManager = $templateManager;
    }

    public function createAction(Request $request)
    {
        $event = new GetResponseEvent($request);
        $this->eventDispatcher->dispatch(UserEvents::CREATE_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $user = $this->userDirector->build();
        $form = $this->formHandler->createForm();
        $form->setData($user);

        $event = new GetUserResponseEvent($user, $request);
        $this->eventDispatcher->dispatch(UserEvents::PRE_CREATE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        if($this->formHandler->handle($form, $request)) {
            if ($this->manager->save($user)) {
                $event = new GetUserResponseEvent($user, $request);
                $this->eventDispatcher->dispatch(UserEvents::CREATE_SUCCESS, $event);

                if (null === $response = $event->getResponse()) {
                    $url = $this->urlManager->generate('user_view', array(
                        'id' => $user->getId()
                    ));
                    
                    $response = $this->templateManager->redirect($url);
                }

                $this->eventDispatcher->dispatch(UserEvents::CREATE_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }

        return $this->templateManager->render('user_create', array(
            'form' => $form->createView()
        ));
    }

    public function createFormAction()
    {
        $form = $this->formHandler->buildForm();

        return $this->templateManager->render('user_create_form', array(
            'form' => $form->createView()
        ));
    }
}
