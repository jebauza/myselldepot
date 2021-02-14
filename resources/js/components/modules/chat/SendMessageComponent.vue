<template>
    <form action="#" method="post">
        <div class="input-group">
            <input type="text" v-model="message" @keydown.enter.prevent="sendMessage" name="message" placeholder="Escriba un Mensaje ..." class="form-control">
            <span class="input-group-append">
                <button type="button" class="btn btn-primary" @click.prevent="sendMessage">Send</button>
            </span>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        contact: {
            type: Object,
            default: null
        }
    },

    data() {
        return {
            message: ''

        }
    },

    methods: {
        sendMessage() {
            if (!this.message || !this.contact) {
                return;
            }

            const url = '/cmsapi/chat/send-message';
            axios.post(url, {
                contact: this.contact.id,
                text: this.message
            })
            .then(res => {
                this.$emit('new_message', res.data);
                this.message = '';
            })
            .catch(err => {
                console.error(err);
            });
        }
    },


}
</script>

<style>

</style>
