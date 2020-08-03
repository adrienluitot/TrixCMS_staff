<?php

use App\TModels\Permission;
use Illuminate\Database\Eloquent\Model;

$supportPermissions = [
    'DASHBOARD_STAFF_VIEW_RANKS',
    'DASHBOARD_STAFF_ADD_RANK',
    'DASHBOARD_STAFF_DELETE_RANK',
    'DASHBOARD_STAFF_EDIT_RANK',

    'DASHBOARD_STAFF_VIEW_MEMBERS',
    'DASHBOARD_STAFF_EDIT_MEMBER',
    'DASHBOARD_STAFF_ADD_MEMBER',
    'DASHBOARD_STAFF_DELETE_MEMBER',
];

Model::unguard();

foreach ($supportPermissions as $permission) {
    Permission::addOrUpdate($permission, "staff_alfiory::admin.permission_" . $permission, "plugin", "899612438");
}

Model::reguard();