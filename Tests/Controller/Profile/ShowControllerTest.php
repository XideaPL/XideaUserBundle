<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Controller\Profile;

use Xidea\Bundle\UserBundle\Tests\Controller\ControllerTestCase;

class ShowControllerTest extends ControllerTestCase
{
    public function testShowAction()
    {
        //$client = $this->logIn();
        $client = $this->createClient();
        $user = $client->getContainer()->get('xidea_user.user.loader')->loadOneByUsername('johndoe');
        
        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('xidea_profile_show', array('id'=>$user->getId())));

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("John Doe")')->count()
        );
    }
}

