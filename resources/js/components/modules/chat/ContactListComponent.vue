<template>
    <div class="direct-chat-contacts">
        <ul class="contacts-list">

            <li v-for="(user, index) in contacts" :key="index" @click.prevent="contactSelect(user)" :class="selectedUser == user.id ? 'selected' : ''">
                <a href="#">
                    <img v-if="user.profile_image" class="contacts-list-img" :src="user.profile_image.url" :alt="user.username">
                    <img v-else class="contacts-list-img" :src="'/img/user' + (Math.floor(Math.random() * (7 - 1)) + 1) + '-128x128.jpg'">

                    <div class="contacts-list-info">
                        <span class="contacts-list-name">
                            {{user.fullName}}
                        </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                </a>
            </li>

        </ul>
        <!-- /.contacts-list -->
    </div>
</template>

<script>
export default {
    props: {
        contacts: {
            type: Array,
            default: []
        }
    },

    data() {
        return {
            selectedUser: ''
        }
    },

    methods: {
        contactSelect(user) {
            this.selectedUser = user.id
            this.$emit('contactSelect', user);
        }
    },
}
</script>

<style scoped>
    .selected{
        background-color: #7FFFD466;
    }
</style>
