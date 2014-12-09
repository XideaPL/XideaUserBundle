<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\Form\FormInterface;

use Xidea\Bundle\UserBundle\Form\Factory\FormFactoryInterface,
    Xidea\Bundle\UserBundle\UserEvents,
    Xidea\Bundle\UserBundle\Event\FormEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserFormHandler implements UserFormHandlerInterface
{
    /*
     * @var FormFactoryInterface
     */
    protected $formFactory;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /*
     * @var string
     */
    protected $requestMethod = 'POST';
    
    /**
     * Constructs a form handler.
     *
     * @param EngineInterface The engine
     */
    public function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRequestMethod($method)
    {
        $this->requestMethod = $method;
    }
    
    /**
     * {@inheritdoc}
     */
    public function createForm()
    {
        return $this->formFactory->createForm();
    }

    /**
     * {@inheritdoc}
     */
    public function handle(FormInterface $form, Request $request)
    {
        if ($request->isMethod($this->requestMethod)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(UserEvents::FORM_VALID, $event);
                
                return true;
            }
        }
        
        return false;
    }
}
