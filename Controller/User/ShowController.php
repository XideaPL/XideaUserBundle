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

    protected $userLoader;

    public function __construct(ConfigurationInterface $configuration, UserLoaderInterface $userLoader)
    {
        parent::__construct($configuration);

        $this->userLoader = $userLoader;
    }

    protected function loadModel($id)
    {
        $user = $this->userLoader->load($id);

        if (!$user instanceof UserInterface) {
            throw new NotFoundHttpException('user.not_found');
        }

        return $user;
    }

    protected function onPreShow($model, Request $request)
    {
        return;
    }
}
