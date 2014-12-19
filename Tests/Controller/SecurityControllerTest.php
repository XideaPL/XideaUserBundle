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
        $client = static::createClient();

        $crawler = $client->request('GET', $this->router->generate('_login'));

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Logowanie")')->count()
        );
    }
}

