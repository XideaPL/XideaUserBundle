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
    protected $userLoader;

    public function __construct(ConfigurationInterface $configuration, UserLoaderInterface $userLoader)
    {
        parent::__construct($configuration);

        $this->userLoader = $userLoader;
        $this->listTemplate = 'user_list';
    }
    
    protected function loadModels(Request $request)
    {
        return $this->userLoader->loadAll();
    }
    
    protected function onPreList($models, Request $request)
    {
        return;
    }
}
