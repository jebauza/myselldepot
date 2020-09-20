<template>
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link navbar-danger">
            <img :src="basepath + '/img/AdminLTELogo.png'" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">MySellDepot</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="basepath + '/img/user2-160x160.jpg'" class="img-circle elevation-2" alt="Administrador">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Administrador</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact"
                    data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item has-treeview menu-open">
                        <router-link :to="{path: '/home'}" :class="['nav-link', isActive('/home') ? 'active' : '']">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p> Dashboard</p>
                        </router-link>
                    </li>

                    <li class="nav-header">OPERACIONES</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Pedidos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{path: '/clients'}" :class="['nav-link', isActive('/clients') ? 'active' : '']">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Clientes</p>
                        </router-link>
                    </li>

                    <li class="nav-header">CONFIGURACION</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>Categorias</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-apple-alt"></i>
                            <p>Productos</p>
                        </a>
                    </li>

                    <li class="nav-header">ADMINISTRACION</li>
                    <li class="nav-item">
                        <router-link :to="{path: '/users'}" :class="['nav-link', isActive('/users') ? 'active' : '']">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Usuarios</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-unlock-alt"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Permisos</p>
                        </a>
                    </li>

                    <li class="nav-header">REPORTES</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file-export"></i>
                            <p>Pedidos</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    props: ['basepath'],
    methods: {
        isActive(path_url) {
            return this.currentPage.indexOf(path_url) === 0;
        }
    },
    computed: {
        currentPage() {
            return this.$route.path;
        }
    }
}
</script>

<style>

</style>
