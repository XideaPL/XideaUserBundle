<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Xidea\User\LoaderInterface;
use Xidea\Base\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractController;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ListController extends AbstractController
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
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $models = $this->loadModels($request);
        
        return $this->render('user_list', array(
            'models' => $models
        ));
    }
    
    /**
     * @param Request $request
     * @return array
     */
    protected function loadModels(Request $request)
    {
        return $this->loader->loadByPage(
            $request->query->get($this->configuration->getPaginationParameterName(), 1),
            $this->configuration->getPaginationLimit()
        );
    }
}
