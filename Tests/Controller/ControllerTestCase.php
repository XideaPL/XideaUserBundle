<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Symfony\Component\Routing\RouterInterface;

abstract class ControllerTestCase extends WebTestCase
{
    /*
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;
    
    public function setUp()
    {
        static::bootKernel();
        
        $this->router = static::$kernel->getContainer()->get('router');
    }
}

