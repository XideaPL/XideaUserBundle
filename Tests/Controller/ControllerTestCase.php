<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Controller;

use Symfony\Component\BrowserKit\Cookie,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ControllerTestCase extends WebTestCase
{   
    protected function loadAdminUser($client)
    {
        $userLoader = $client->getContainer()->get('xidea_user.user_loader');
        return $userLoader->loadOneByUsername('admin');
        
    }
    protected function logIn()
    {
        $client = static::createClient();
        $session = $client->getContainer()->get('session');
        
        $firewall = 'app';
        $user = $this->loadAdminUser($client);
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        
        return $client;
    }
}

