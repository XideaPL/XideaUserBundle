<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xidea\User\LoaderInterface;
use Xidea\Base\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractController;
use Xidea\User\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ShowController extends AbstractController
{
    /*
     * @var LoaderInterface
     */
    protected $loader;
    
    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param LoaderInterface $loader
     */
    public function __construct(ConfigurationInterface $configuration, LoaderInterface $loader)
    {
        parent::__construct($configuration);

        $this->loader = $loader;
    }
    
    /**
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function showAction($id, Request $request)
    {
        $model = $this->loadModel($id);
        
        return $this->render('user_show', array(
            'model' => $model
        ));
    }

    /**
     * @param int $id
     * 
     * @return TicketInterface|null
     */
    protected function loadModel($id)
    {
        $user = $this->loader->load($id);

        if (!$user instanceof UserInterface) {
            throw new NotFoundHttpException('user.not_found');
        }

        return $user;
    }
}
