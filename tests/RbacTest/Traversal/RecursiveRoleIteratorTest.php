<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RbacTest\Traversal;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Rbac\Role\HierarchicalRole;
use Rbac\Role\Role;
use Rbac\Traversal\RecursiveRoleIterator;
use stdClass;

#[CoversClass('\Rbac\Traversal\RecursiveRoleIterator')]
class RecursiveRoleIteratorTest extends TestCase
{
    public function testAcceptTraversable()
    {
        $roles    = new ArrayIterator([new Role('foo'), new Role('bar')]);
        $iterator = new RecursiveRoleIterator($roles);

        $this->assertEquals($iterator->getArrayCopy(), $roles->getArrayCopy());
    }

    public function testValidateRoleInterface()
    {
        $foo      = new Role('Foo');
        $roles    = [$foo, new stdClass];
        $iterator = new RecursiveRoleIterator($roles);

        $this->assertSame($iterator->current(), $foo);
        $this->assertTrue($iterator->valid());

        $iterator->next();

        $this->assertFalse($iterator->valid());
    }

    public function testHasChildrenReturnsFalseIfCurrentRoleIsNotHierarchical()
    {
        $foo      = new Role('Foo');
        $roles    = [$foo];
        $iterator = new RecursiveRoleIterator($roles);

        $this->assertFalse($iterator->hasChildren());
    }

    public function testHasChildrenReturnsFalseIfCurrentRoleHasNotChildren()
    {
        $role     = $this->createMock('Rbac\Role\HierarchicalRoleInterface');
        $iterator = new RecursiveRoleIterator([$role]);

        $role->expects($this->once())->method('hasChildren')->willReturn(false);

        $this->assertFalse($iterator->hasChildren());
    }

    public function testHasChildrenReturnsTrueIfCurrentRoleHasChildren()
    {
        $role     = $this->createMock('Rbac\Role\HierarchicalRoleInterface');
        $iterator = new RecursiveRoleIterator([$role]);

        $role->expects($this->once())->method('hasChildren')->willReturn(true);

        $this->assertTrue($iterator->hasChildren());
    }

    public function testGetChildrenReturnsAnRecursiveRoleIteratorOfRoleChildren()
    {
        $baz = new HierarchicalRole('Baz');
        $baz->addChild(new Role('Foo'));
        $baz->addChild(new Role('Bar'));

        $roles    = [$baz];
        $iterator = new RecursiveRoleIterator($roles);

        $this->assertEquals(
            $iterator->getChildren(),
            new RecursiveRoleIterator($baz->getChildren())
        );
    }
}
