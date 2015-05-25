<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Model;

use Xidea\Bundle\UserBundle\Tests\Fixtures\Model\User;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testUsername()
    {
        $user = $this->createUser();
        $this->assertNull($user->getUsername());
        
        $user->setUsername('johndoe');
        $this->assertEquals('johndoe', $user->getUsername());
    }
    
    protected function createUser()
    {
        return new User();
    }
}
