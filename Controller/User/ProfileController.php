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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Xidea\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ProfileController
{
    /*
     * @var SecurityContextInterface
     */
    protected $securityContext;

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

    public function __construct(SecurityContextInterface $securityContext, EventDispatcherInterface $eventDispatcher, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->securityContext = $securityContext;
        $this->eventDispatcher = $eventDispatcher;
        $this->templating = $templating;
        $this->translator = $translator;
    }

    public function viewAction()
    {
        $user = $this->securityContext->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        return $this->templating->renderResponse('XideaUserBundle:User/Profile:view.html.twig', array(
                    'user' => $user
        ));
    }
}
