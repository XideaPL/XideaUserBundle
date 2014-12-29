<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Controller\User;

use Xidea\Bundle\UserBundle\Tests\Controller\ControllerTestCase;

class CreateControllerTest extends ControllerTestCase
{
    public function testCreateAction()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('xidea_user_create'));

        $this->assertGreaterThan(
            0,
            $crawler->filter('input')->count()
        );
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Nowy użytkownik")')->count()
        );
    }
}

