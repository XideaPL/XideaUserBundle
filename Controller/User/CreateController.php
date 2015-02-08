<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

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

    public function __construct(ConfigurationInterface $configuration, UserDirectorInterface $userDirector, UserManagerInterface $objectManager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration, $objectManager, $formHandler);

        $this->userDirector = $userDirector;
    }

    protected function createObject()
    {
        return $this->userDirector->build();
    }

    protected function onPreCreate($object, $request)
    {
        $this->dispatch(UserEvents::PRE_CREATE, $event = new GetUserResponseEvent($object, $request));

        return $event->getResponse();
    }

    protected function onCreateSuccess($object, $request)
    {
        $this->dispatch(UserEvents::CREATE_SUCCESS, $event = new GetUserResponseEvent($object, $request));

        if (null === $response = $event->getResponse()) {
            $response = $this->redirectToRoute('xidea_user_show', array(
                'id' => $object->getId()
            ));
        }

        return $response;
    }

    protected function onCreateCompleted($object, $request, $response)
    {
        $this->dispatch(UserEvents::CREATE_COMPLETED, new FilterUserResponseEvent($object, $request, $response));
    }
}
