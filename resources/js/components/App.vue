<template>
<div>
    <Navbar :basepath="basepath"></Navbar>

    <Sidebar :basepath="basepath" :auth_user="authUser"></Sidebar>

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
    data() {
        return {
            authUser: this.auth_user
        }
    },
    mounted() {
        EventBus.$on('verifyAuthenticatedUser', user => {
            if(user.id === this.authUser.id) {
                this.authUser = user;
            }
        });
    },
}
</script>
