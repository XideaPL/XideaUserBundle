<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Xidea\Component\User\Builder\UserDirectorInterface,
    Xidea\Component\User\Manager\UserManagerInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractCreateController,
    Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\UserBundle\UserEvents,
    Xidea\Bundle\UserBundle\Event\GetUserResponseEvent,
    Xidea\Bundle\UserBundle\Event\FilterUserResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class CreateController extends AbstractCreateController
{
    /*
     * @var UserDirectorInterface
     */

    protected $userDirector;

    /*
     * @var UserManagerInterface
     */
    protected $userManager;

    public function __construct(ConfigurationInterface $configuration, UserDirectorInterface $userDirector, UserManagerInterface $modelManager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration, $modelManager, $formHandler);

        $this->userDirector = $userDirector;

        $this->createTemplate = 'user_create';
        $this->createFormTemplate = 'user_create_template';
    }

    protected function createModel()
    {
        return $this->userDirector->build();
    }

    protected function onPreCreate($model, Request $request)
    {
        $this->dispatch(UserEvents::PRE_CREATE, $event = new GetUserResponseEvent($model, $request));

        return $event->getResponse();
    }

    protected function onCreateSuccess($model, Request $request)
    {
        $this->dispatch(UserEvents::CREATE_SUCCESS, $event = new GetUserResponseEvent($model, $request));

        if (null === $response = $event->getResponse()) {
            $response = $this->redirectToRoute('xidea_user_show', array(
                'id' => $model->getId()
            ));
        }

        return $response;
    }

    protected function onCreateCompleted($model, Request $request, Response $response)
    {
        $this->dispatch(UserEvents::CREATE_COMPLETED, $event = new FilterUserResponseEvent($model, $request, $response));
        
        return $event->getResponse();
    }
}
