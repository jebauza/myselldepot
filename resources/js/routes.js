import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: require('./components/modules/authenticate/LoginComponent').default
        },
        {
            path: '/home',
            name: 'home',
            component: require('./components/dashboard/HomeComponent').default,
            meta: {
                breadcrumb: [
                    { name: 'Home' }
                ]
            }
        },
        {
            path: '/users',
            name: 'users',
            component: require('./components/modules/user/UserListComponent').default,
            meta: {
                breadcrumb: [
                    { name: 'Home', link: '/home' },
                    { name: 'Usuarios' }
                ]
            }
        },
        {
            path: '/users/:id/profile/',
            name: 'profile',
            component: require('./components/modules/user/UserProfileComponent').default,
            props: true,
            meta: {
                breadcrumb: [
                    { name: 'Home', link: '/home' },
                    { name: 'Usuarios', link: '/users' },
                    { name: 'Perfil' }
                ]
            }
        },
        {
            path: '/roles',
            name: 'roles',
            component: require('./components/modules/role/RoleListComponent.vue').default,
            meta: {
                breadcrumb: [
                    { name: 'Home', link: '/home' },
                    { name: 'Roles' }
                ]
            }
        },
        {
            path: '/clients',
            name: 'clients',
            component: require('./components/modules/client/ClientListComponent').default,
            meta: {
                breadcrumb: [
                    { name: 'Home', link: '/home' },
                    { name: 'Clientes' }
                ]
            }
        }

    ],
    mode: 'history'
});
