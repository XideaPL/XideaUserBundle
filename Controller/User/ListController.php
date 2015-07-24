<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Xidea\Component\User\Loader\UserLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractListController;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ListController extends AbstractListController
{
    /*
     * @var UserLoaderInterface
     */
    protected $loader;

    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param UserLoaderInterface $loader
     */
    public function __construct(ConfigurationInterface $configuration, UserLoaderInterface $loader)
    {
        parent::__construct($configuration);

        $this->loader = $loader;
        $this->listTemplate = 'user_list';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function loadModels(Request $request)
    {
        return $this->loader->loadByPage(
            $request->query->get($this->configuration->getPaginationParameterName(), 1),
            $this->configuration->getPaginationLimit()
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function onPreList($models, Request $request)
    {
        return;
    }
}
