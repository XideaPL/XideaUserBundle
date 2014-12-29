<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Controller;

class SecurityControllerTest extends ControllerTestCase
{
    public function testLoginAction()
    {
        $client = $this->createClient();
        
        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('_login'));

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Logowanie")')->count()
        );
    }
    
    public function testLoginActionSubmit()
    {
//        $client = $this->createClient();
//        
//        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('_login'));
//
//        $userLoader = $client->getContainer()->get('xidea_user.user_loader');
//        $user = $userLoader->loadOneByUsername('admin');
//        
//        $form = $crawler->selectButton('Zaloguj')->form(array(
//            '_username' => $user->getUsername(),
//            '_password' => $user->getPassword()
//        ));
//
//        $crawler = $client->submit($form);
//        
//        $client->followRedirect();
//        
//        $this->assertTrue($client->getResponse()->isSuccessful());
//
//        $this
//            ->assertRegExp('/\/admin\/notifications/',
//                $client->getResponse()->getContent());
    }
}

