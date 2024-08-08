<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rbac\Role;

use Traversable;

/**
 * Simple implementation for a hierarchical role
 */
class HierarchicalRole extends Role implements HierarchicalRoleInterface
{
    /**
     * @var array|RoleInterface[]
     */
    protected array $children = [];

    /**
     * {@inheritDoc}
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren(): Traversable|array
    {
        return $this->children;
    }

    /**
     * Add a child role
     *
     * @param RoleInterface $child
     */
    public function addChild(RoleInterface $child): void
    {
        $this->children[$child->getName()] = $child;
    }
}
