<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Permissions
 */

namespace RbacTest;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Rbac\Role\Role;

#[CoversClass('\Rbac\Role\Role')]
class RoleTest extends TestCase
{
    public function testSetNameByConstructor()
    {
        $role = new Role('phpIsHell');
        $this->assertEquals('phpIsHell', $role->getName());
    }

    public function testRoleCanAddPermission()
    {
        $role = new Role('php');

        $role->addPermission('debug');
        $this->assertTrue($role->hasPermission('debug'));

        $permission = $this->createMock('Rbac\Permission\PermissionInterface');
        $permission->expects($this->once())->method('__toString')->willReturn('interface');
        $role->addPermission($permission);

        $this->assertTrue($role->hasPermission('interface'));
    }
}
