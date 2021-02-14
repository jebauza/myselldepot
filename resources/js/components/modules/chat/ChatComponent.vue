<template>
    <div class="card direct-chat direct-chat-primary" :class="openAndCloseContacts ? 'direct-chat-contacts-open' : ''">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">Mensajes Instantaneos</h3>

            <div class="card-tools">
                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" @click.prevent="openAndCloseContacts = !openAndCloseContacts">
                    <i class="fas fa-comments"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <Conversation ref="conversation" :messages="messages" :contact="selectedContact"></Conversation>

            <ContactList :contacts="contacts" @contactSelect="getMessages"></ContactList>
        </div>
        <div class="card-footer">
            <SendMessage @new_message="newMessage" :contact="selectedContact"></SendMessage>
        </div>

    </div>
</template>

<script>
import ContactList from './ContactListComponent';
import Conversation from './ConversationComponent';
import SendMessage from './SendMessageComponent';

export default {
    components: {ContactList, Conversation, SendMessage},

    props: ['user'],

    mounted() {
        Echo.private(`message.${this.user.id}`)
            .listen('.new.message', (e) => {
                console.log(e);
            });

        this.getContactList();
    },

    data() {
        return {
            contacts: [],
            messages: [],
            selectedContact: null,
            openAndCloseContacts: false
        }
    },

    methods: {
        getContactList() {
            const url = 'cmsapi/chat/contacts';

            axios.get(url)
            .then(res => {
                this.contacts = res.data
            })
            .catch(err => {
                console.error(err);
            })
        },
        newMessage(message) {
            this.messages.push(message);
        },
        getMessages(user) {
            this.selectedContact = user;
            this.messages = [];
            this.openAndCloseContacts = false;

            const url = `cmsapi/chat/${user.id}/messages`;
            /* const loading = this.$vs.loading({
                target: this.$refs.conversation,
                color: 'dark'
            }); */

            axios.get(url)
            .then(res => {
                // loading.close();
                this.messages = res.data;
            })
            .catch(err => {
                // loading.close();
                console.error(err);
            });
        }
    },

}
</script>

<style lang="scss" scoped>

</style>
