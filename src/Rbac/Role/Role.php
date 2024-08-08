<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rbac\Role;

/**
 * Simple implementation for a role without hierarchy
 * and using strings as permissions
 */
class Role implements RoleInterface
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string[]
     */
    protected array $permissions = [];

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = (string) $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Add a permission
     *
     * @param string $permission
     */
    public function addPermission(string $permission): void
    {
        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * Checks if a permission exists for this role
     *
     * @param mixed $permission
     * @return bool
     */
    public function hasPermission(mixed $permission): bool
    {
        return isset($this->permissions[(string) $permission]);
    }
}
