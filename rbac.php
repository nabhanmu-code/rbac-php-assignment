<?php

$roles = [];
$users = [];

function assignPermission(&$roles, $role, $permission)
{
    if (!isset($roles[$role])) {
        $roles[$role] = [];
    }
    $roles[$role][] = $permission;
}

function assignUser(&$users, $username, $role)
{
    $users[$username] = $role;
}

function checkPermission($username, $permission, $users, $roles)
{
    if (!isset($users[$username])) {
        return false;
    }

    $role = $users[$username];

    if (!isset($roles[$role])) {
        return false;
    }

    return in_array($permission, $roles[$role]);
}

assignPermission($roles, "Admin", "Create");
assignPermission($roles, "Admin", "View");
assignPermission($roles, "Admin", "Update");
assignPermission($roles, "Admin", "Delete");

assignPermission($roles, "Manager", "View");
assignPermission($roles, "Manager", "Update");

assignPermission($roles, "Customer", "View");

assignUser($users, "Ahmad", "Admin");
assignUser($users, "Omar", "Manager");
assignUser($users, "Sara", "Customer");

echo "<h2>Role-Based Access Control (RBAC) - Account Object</h2>";

echo "<h3>Roles and permissions</h3>";
foreach ($roles as $role => $permissions) {
    echo "$role: " . implode(", ", $permissions) . "<br>";
}

echo "<h3>Users and roles</h3>";
foreach ($users as $username => $role) {
    echo "$username -> $role<br>";
}

echo "<h3>Access test</h3>";
$allPermissions = ["Create", "View", "Update", "Delete"];

foreach ($users as $username => $role) {
    foreach ($allPermissions as $permission) {
        if (checkPermission($username, $permission, $users, $roles)) {
            echo "$username ($role) - $permission Account: Access Granted<br>";
        } else {
            echo "$username ($role) - $permission Account: Access Denied<br>";
        }
    }
    echo "<br>";
}
