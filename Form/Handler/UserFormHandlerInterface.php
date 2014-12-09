<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormInterface;

/**
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
interface UserFormHandlerInterface
{
    /**
     * Set request method
     * 
     * @param string $method A valid HTTP method (for example, GET or POST)
     */
    function setRequestMethod($method);
    
    /**
     * Create the from
     * 
     * @return \Symfony\Component\Form\FormInterface
     */
    function createForm();
    
    /**
     * Process the form
     * 
     * @param FormInterface $form A form
     * @param Request $request
     * 
     * @return bool
     */
    function handle(FormInterface $form, Request $request);
}
