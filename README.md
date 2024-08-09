# Rbac


[![Build Status](https://github.com/lm-commons/rbac/actions/workflows/build_test.yml/badge.svg)](https://github.com/lm-commons/rbac/actions/workflows/build_test.yml)
[![Latest Stable Version](http://poser.pugx.org/lm-commons/rbac/v)](https://packagist.org/packages/lm-commons/rbac)
[![Total Downloads](http://poser.pugx.org/lm-commons/rbac/downloads)](https://packagist.org/packages/lm-commons/rbac)
[![License](http://poser.pugx.org/lm-commons/rbac/license)](https://packagist.org/packages/lm-commons/rbac)
[![Coverage Status](https://coveralls.io/repos/github/LM-Commons/rbac/badge.svg?branch=1.x)](https://coveralls.io/github/LM-Commons/rbac?branch=1.x)
[![Static Badge](https://img.shields.io/badge/Chat_on-Slack-blue)](https://join.slack.com/t/lm-commons/shared_invite/zt-2gankt2wj-FTS45hp1W~JEj1tWvDsUHQ)

![Dynamic JSON Badge](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fapi.github.com%2Frepos%2Flm-commons%2Frbac%2Fproperties%2Fvalues&query=%24%5B%3A1%5D.value&label=Maintenance%20Status)

### **IMPORTANT!!** 
### The only purpose of this package is to provide a version of zfr/rbac 1.2 that support PHP 8 and fixes the deprecation notices.

Rbac (not to be confused with ZfcRbac/LmcRbac) is a pure PHP implementation of the RBAC (*Role based access control*)
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

This library is used in LM-Commons/LmcRbacMvc v3.
