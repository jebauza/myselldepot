<template>
    <div class="direct-chat-messages" ref="bottom">

        <template v-if="contact">

            <template v-if="messages.length > 0">
                <div v-for="(message, index) in messages" :key="index" class="direct-chat-msg " :class="message.from == contact.id ? '' : 'right'">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name " :class="message.from == contact.id ? 'float-left' : 'float-right'">{{ getMessageData(message, 'fullName') }}</span>
                        <span class="direct-chat-timestamp " :class="message.from == contact.id ? 'float-right' : 'float-left'">{{ getMessageData(message, 'created_at') }}</span>
                    </div>
                    <img class="direct-chat-img" :src="getMessageData(message, 'url_img')" :alt="getMessageData(message, 'fullName')">
                    <div class="direct-chat-text">
                        {{ message.text }}
                    </div>
                </div>
            </template>
            <template v-else>
                <vs-alert shadow >
                    <template #title>
                        Comienza a excribirle a {{ contact.fullName }}
                    </template>
                </vs-alert>
            </template>

        </template>
        <template v-else>
            <vs-alert shadow >
                <template #title>
                    Mensaje
                </template>
                Debe seleccionar un contacto para iniciar una conversacion.
            </vs-alert>
        </template>


    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: {
        messages: {
            type: Array,
            default: []
        },
        contact: {
            type: Object,
            default: null
        }
    },

    watch: {
        messages() {
            this.scrollToBottom();
        },
        contact() {
            this.scrollToBottom();
        },
    },

    data() {
        return {

        }
    },

    methods: {
        getMessageData(message, data) {
            if (!message) {
                return '';
            }

            switch (data) {
                case 'fullName':
                    return message.from_user.fullName || '';
                    break;

                case 'created_at':
                    return moment(message.created_at, 'YYYY-MM-DD HH:mm:ss').format('lll');
                    break;

                case 'url_img':
                    return (message.from_user.profile_image && message.from_user.profile_image.url) ? message.from_user.profile_image.url : '/img/user3-128x128.jpg';
                    break;

                default:
                    return '';
                    break;
            }
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.bottom.scrollTop = this.$refs.bottom.scrollHeight - this.$refs.bottom.clientHeight;
            }, 100);
        }
    },
}
</script>

<style>

</style>
