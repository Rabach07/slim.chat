<template>
    <div class="flex h-screen">
        <div class="w-1/5 border-r">
            <conversations @selected="conversationSelected" />
        </div>

        <div class="flex-1 h-screen flex flex-col border-r">
            <conversation-detail v-if="selectedConversation" :conversation="selectedConversation" @selected="conversationSelected" />

            <messages v-if="selectedConversation" :conversation="selectedConversation" />

            <compose-message v-if="selectedConversation && selectedConversation.status == 1" :conversation="selectedConversation" />

            <div v-if="!selectedConversation" class="h-full flex items-center w-3/4 mx-auto text-center select-none">
                <div>
                    <img src="/images/empty/no_conversation_selected.svg">
                    <h1 class="mt-10">Start chatting!</h1>
                    <p>
                        Select an existing chat from the conversations on the left, <br>
                        or start a new chat from the people panel.
                    </p>
                </div>
            </div>
        </div>

        <div class="w-1/5">
            <properties v-if="selectedConversation" :visitor_id="selectedConversation.visitor_id" />
        </div>
    </div>
</template>

<script>
    import ConversationDetail from './../components/ConversationDetail'
    import Conversations from './../components/Conversations'
    import ComposeMessage from './../components/ComposeMessage'
    import Messages from './../components/Messages'
    import Properties from './../components/Properties'

    export default {
        components: {
            ConversationDetail,
            Conversations,
            ComposeMessage,
            Messages,
            Properties
        },

        props: [''],

        data() {
            return {
                selectedConversation: null,
            }
        },

        methods: {
            conversationSelected(event) {
                this.selectedConversation = event
            }
        },

        created() {
            Echo.channel('businesses.' + this.$root.business.id + '.conversations')
            .listen('ConversationUpdated', event => {
                this.selectedConversation = event.conversation
            })
        },

        beforeDestroyed() {
            Echo.leave('businesses.' + this.$root.business.id + '.conversations')
        }
    }
</script>
