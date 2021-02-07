<template>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">Mensajes Instantaneos</h3>

            <div class="card-tools">
                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <Conversation></Conversation>

            <ContactList :contacts="contacts" @contactSelect="getMessages"></ContactList>
        </div>
        <div class="card-footer">
            <SendMessage @message="newMessage"></SendMessage>
        </div>

    </div>
</template>

<script>
import ContactList from './ContactListComponent';
import Conversation from './ConversationComponent';
import SendMessage from './SendMessageComponent';

export default {
    components: {ContactList, Conversation, SendMessage},

    mounted() {
        this.getContactList();
    },

    data() {
        return {
            contacts: [],
            messages: []
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
            console.log(message);
        },

        getMessages(user) {
            const url = `cmsapi/chat/${user.id}/messages`;

            axios.get(url)
            .then(res => {
                console.log(res)
            })
            .catch(err => {
                console.error(err);
            });
        }
    },

}
</script>

<style lang="scss" scoped>

</style>
