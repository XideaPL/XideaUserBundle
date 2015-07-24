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
use Xidea\Component\User\Loader\UserLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractShowController;
use Xidea\Component\User\Model\UserInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ShowController extends AbstractShowController
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
        $this->showTemplate = 'user_show';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadModel($id)
    {
        $user = $this->loader->load($id);

        if (!$user instanceof UserInterface) {
            throw new NotFoundHttpException('user.not_found');
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function onPreShow($model, Request $request)
    {
        return;
    }
}
