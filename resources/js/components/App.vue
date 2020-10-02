<template>
<div>
    <Navbar :basepath="basepath"></Navbar>

    <Sidebar :basepath="basepath" :auth_user="authUser" :userPermissions="userPermissions"></Sidebar>

    <Content :basepath="basepath"></Content>

    <Footer :basepath="basepath"></Footer>

</div>
</template>

<script>
import Navbar from './layouts/Navbar';
import Sidebar from './layouts/Sidebar';
import Content from './layouts/Content';
import Footer from './layouts/Footer';

export default {
    components: {Navbar,Sidebar,Content,Footer},
    props: ['basepath', 'auth_user'],
    mounted() {
        this.userPermissions = JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        EventBus.$on('verifyAuthenticatedUser', user => {
            if(user.id === this.authUser.id) {
                this.getPermissionsByUser(this.auth_user.id);
                this.authUser = user;
            }
        });
        this.getPermissionsByUser(this.auth_user.id);
    },
    data() {
        return {
            authUser: this.auth_user,
            userPermissions: [],
        }
    },
    methods: {
        getPermissionsByUser(user_id) {
            this.fullscreenLoading = true;
            const url = `/cmsapi/administration/users/${user_id}/get-permissions`;
            axios.get(url)
            .then(res => {
                const permissions = res.data.map(p => p.name);
                sessionStorage.setItem('listPermissionsByAuthUser', JSON.stringify(permissions));
                this.userPermissions = JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
            });
        }
    },
}
</script>
