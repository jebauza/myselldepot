<?php

return [

    'permissions' => [
        /* Users */
        ['name' => 'users.index', 'display_name' => 'Navegar Usuarios'],
        ['name' => 'users.store', 'display_name' => 'Crear Usuarios'],
        ['name' => 'users.show', 'display_name' => 'Ver Usuario'],
        ['name' => 'users.update', 'display_name' => 'Modificar Usuario'],
        ['name' => 'users.activate', 'display_name' => 'Activar Usuarios'],
        ['name' => 'users.deactivate', 'display_name' => 'Desactivar Usuarios'],

        /* Roles */
        ['name' => 'roles.index', 'display_name' => 'Navegar Roles'],
        ['name' => 'roles.store', 'display_name' => 'Crear Roles'],
        ['name' => 'roles.show', 'display_name' => 'Ver Rol'],
        ['name' => 'roles.update', 'display_name' => 'Modificar Rol'],

        /* Categories */
        ['name' => 'categories.index', 'display_name' => 'Navegar Categorías'],
        ['name' => 'categories.store', 'display_name' => 'Crear Categoría'],
        ['name' => 'categories.show', 'display_name' => 'Ver Categoría'],
        ['name' => 'categories.update', 'display_name' => 'Modificar Categoría'],

        /* Products */
        ['name' => 'products.index', 'display_name' => 'Navegar Productos'],
        ['name' => 'products.store', 'display_name' => 'Crear Producto'],
        ['name' => 'products.show', 'display_name' => 'Ver Producto'],
        ['name' => 'products.update', 'display_name' => 'Modificar Producto'],
    ]
];
