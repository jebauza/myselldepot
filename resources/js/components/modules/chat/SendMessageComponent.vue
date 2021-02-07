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
    data() {
        return {
            message: ''

        }
    },

    methods: {
        sendMessage() {
            if (!this.message) {
                return;
            }

            this.$emit('message', this.message);
            this.message = '';
        }
    },


}
</script>

<style>

</style>
