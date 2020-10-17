<?php

return [

    'permissions' => [
        /* Users */
        ['name' => 'users.index', 'display_name' => 'Navegar Usuarios'],
        ['name' => 'users.create', 'display_name' => 'Crear Usuarios'],
        ['name' => 'users.show', 'display_name' => 'Ver Usuario'],
        ['name' => 'users.edit', 'display_name' => 'Modificar Usuario'],
        ['name' => 'users.activate', 'display_name' => 'Activar Usuarios'],
        ['name' => 'users.deactivate', 'display_name' => 'Desactivar Usuarios'],

        /* Roles */
        ['name' => 'roles.index', 'display_name' => 'Navegar Roles'],
        ['name' => 'roles.create', 'display_name' => 'Crear Roles'],
        ['name' => 'roles.show', 'display_name' => 'Ver Rol'],
        ['name' => 'roles.edit', 'display_name' => 'Modificar Rol'],

        /* Categories */
        ['name' => 'categories.index', 'display_name' => 'Navegar Categorías'],
        ['name' => 'categories.create', 'display_name' => 'Crear Categoría'],
        ['name' => 'categories.show', 'display_name' => 'Ver Categoría'],
        ['name' => 'categories.edit', 'display_name' => 'Modificar Categoría'],
    ]
];
