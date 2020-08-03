<?php

return [
    trans("staff_alfiory::admin.staff") => [
        "type" => "dropdown",
        "icon" => "fas fa-users",
//        "permissions" => "DASHBOARD_SUPPORT_VIEW_CATEGORIES|admin",
        "lists" => [
            trans("staff_alfiory::admin.ranks") => [
                "type" => "simple",
                "open_blank" => false,
                "url" => route('admin.staff_alfiory.ranks'),
//                "permissions" => "DASHBOARD_SUPPORT_VIEW_CATEGORIES|admin",
            ],
            trans("staff_alfiory::admin.members") => [
                "type" => "simple",
                "open_blank" => false,
                "url" => route('admin.staff_alfiory.members'),
            ],
        ]
    ],
];

