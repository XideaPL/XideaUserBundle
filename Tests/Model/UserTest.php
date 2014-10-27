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
    public function testId()
    {
        $user = $this->createUser();
        $this->assertNull($user->getId());
        
        $user->setId(1);
        $this->assertEquals(1, $user->getId());
    }
    
    protected function createUser()
    {
        return new User();
    }
}
