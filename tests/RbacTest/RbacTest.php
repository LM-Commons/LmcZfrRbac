<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RbacTest;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Rbac\Rbac;
use Rbac\Role\Role;
use Rbac\Traversal\Strategy\RecursiveRoleIteratorStrategy;

#[CoversClass('\Rbac\Rbac')]
class RbacTest extends TestCase
{
    /*
    public function testConstructorAcceptCustomTraversalStrategy()
    {
        $customStrategy = $this->createMock('Rbac\Traversal\Strategy\TraversalStrategyInterface');
        $rbac           = new Rbac($customStrategy);

        $this->assertAttributeSame($customStrategy, 'traversalStrategy', $rbac);
    }
    */

    public function testInjectSingleRoleToArray()
    {
        $role = new Role('Foo');

        $traversalStrategy = $this->createMock('Rbac\Traversal\Strategy\TraversalStrategyInterface');
        $traversalStrategy->expects($this->once())
            ->method('getRolesIterator')
            ->with($this->equalTo([$role]))
            ->willReturn(new ArrayIterator([]));

        $rbac = new Rbac($traversalStrategy);

        $rbac->isGranted($role, 'permission');
    }

    public function testFetchIteratorFromTraversalStrategy()
    {
        $traversalStrategy = $this->createMock('Rbac\Traversal\Strategy\TraversalStrategyInterface');
        $traversalStrategy->expects($this->once())
            ->method('getRolesIterator')
            ->willReturn(new ArrayIterator([]));

        $rbac = new Rbac($traversalStrategy);

        $rbac->isGranted([], 'permission');
    }

    public function testTraverseRoles()
    {
        $role = $this->createMock('Rbac\Role\RoleInterface');
        $role->expects($this->exactly(3))->method('hasPermission')->with($this->equalTo('permission'))
            ->willReturn(false);

        $roles = [$role, $role, $role];
        $rbac  = new Rbac(new RecursiveRoleIteratorStrategy());

        $rbac->isGranted($roles, 'permission');
    }

    public function testReturnTrueWhenRoleHasPermission()
    {
        $grantedRole = $this->createMock('Rbac\Role\RoleInterface');
        $grantedRole->expects($this->once())
            ->method('hasPermission')
            ->with('permission')
            ->willReturn(true);

        $nextRole = $this->createMock('Rbac\Role\RoleInterface');
        $nextRole->expects($this->never())->method('hasPermission');

        $roles = [$grantedRole, $nextRole];
        $rbac  = new Rbac(new RecursiveRoleIteratorStrategy());

        $this->assertTrue($rbac->isGranted($roles, 'permission'));
    }

    public function testReturnFalseIfNoRoleHasPermission()
    {
        $roles = [new Role('Foo'), new Role('Bar')];
        $rbac  = new Rbac(new RecursiveRoleIteratorStrategy());

        $this->assertFalse($rbac->isGranted($roles, 'permission'));
    }

    public function testGetTraversalStrategy()
    {
        $customStrategy = $this->createMock('Rbac\Traversal\Strategy\TraversalStrategyInterface');
        $rbac           = new Rbac($customStrategy);

        $this->assertSame($customStrategy, $rbac->getTraversalStrategy());
    }
}
