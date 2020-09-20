import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
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
