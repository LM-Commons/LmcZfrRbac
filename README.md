# ZfrRbac


[![Build Status](https://github.com/lm-commons/LmcRbac/actions/workflows/build_test.yml/badge.svg)](https://github.com/lm-commons/LmcRbac/actions/workflows/build_test.yml)
[![Latest Stable Version](https://poser.pugx.org/lm-commons/zfrrbac/v/stable.png)](https://packagist.org/packages/zfr/rbac)
[![Total Downloads](https://poser.pugx.org/lm-commons/zfrrbac/downloads.png)](https://packagist.org/packages/zfr/rbac)

**IMPORTANT** The only purpose of this package is to provide a version of zfr/rbac 1.2 that
support PHP 8 and fixes the deprecation notices.

Rbac (not to be confused with ZfcRbac) is a pure PHP implementation of the RBAC (*Role based access control*)
concept. Actually, it is a Zend Framework 3 prototype of the ZF2 Zend\Permissions\Rbac component.

It aims to fix some design mistakes that were made to make it more usable and more efficient.

It differs on those points:

* A `PermissionInterface` has been introduced.
* `RoleInterface` no longer have `setParent` and `getParent` methods, and cannot have children anymore (this is
used to implement a simpler "flat RBAC").
* A new `HierarchicalRoleInterface` has been introduced to allow roles to have children.
* Method `hasPermission` on a role no longer recursively iterate the children role, but only check its own permissions.
To properly check if a role is granted, you should use the `isGranted` method of the `Rbac` class.
* `Rbac` class is no longer a container. Instead, it just has a `isGranted` method. The container was complex to
properly handle because of role duplication, which could lead to security problems if not used correctly.

This library is used in ZfcRbac 2.0
