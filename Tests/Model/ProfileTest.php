<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Tests\Model;

use Xidea\Bundle\UserBundle\Tests\Fixtures\Model\Profile;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class ProfileTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $profile = $this->createProfile();
        $this->assertNull($profile->getName());
        
        $profile->setName('John Doe');
        $this->assertEquals('John Doe', $profile->getName());
    }
    
    protected function createProfile()
    {
        return new Profile();
    }
}
