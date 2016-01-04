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
use Xidea\User\DirectorInterface,
    Xidea\User\ManagerInterface;
use Xidea\Base\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractController,
    Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\UserBundle\UserEvents,
    Xidea\Bundle\UserBundle\Event\GetResponseEvent,
    Xidea\Bundle\UserBundle\Event\FilterResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class CreateController extends AbstractController
{
    /*
     * @var DirectorInterface
     */

    protected $director;

    /*
     * @var ManagerInterface
     */
    protected $userManager;

    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param UserDirectorInterface $director
     * @param UserManagerInterface $manager
     * @param FormHandlerInterface $formHandler
     */
    public function __construct(ConfigurationInterface $configuration, DirectorInterface $director, ManagerInterface $manager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration);

        $this->director = $director;
        $this->manager = $manager;
        $this->formHandler = $formHandler;
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $model = $this->director->build();

        $event = $this->dispatch(UserEvents::PRE_CREATE, $event = new GetResponseEvent($model, $request));
        if ($event->getResponse() !== null) {
            return $event->getResponse();
        }

        $form = $this->createForm($model);
        if ($this->formHandler->handle($form, $request)) {
            if ($this->manager->save($model)) {
                $event = $this->dispatch(UserEvents::CREATE_SUCCESS, $event = new GetResponseEvent($model, $request));
                
                if (null === $response = $event->getResponse()) {
                    $response = $this->redirectToRoute('xidea_user_show', array(
                        'id' => $model->getId()
                    ));
                }

                $event = $this->dispatch(UserEvents::CREATE_COMPLETED, $event = new FilterResponseEvent($model, $request, $response));
                
                return $event->getResponse();
            }
        }

        return $this->render('user_create', array(
            'form' => $form->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function createFormAction(Request $request)
    {
        $form = $this->createForm();

        return $this->render('user_create_form', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * 
     * @param mixed $model
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createForm($model = null)
    {
        $form = $this->formHandler->createForm();
        if (null !== $model) {
            $form->setData($model);
        }

        return $form;
    }
}
