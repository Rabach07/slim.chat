<template>
    <div class="flex h-screen">
        <conversations @selected="conversationSelected" />

        <div class="flex-1 h-screen flex flex-col border-r">
            <conversation-detail v-if="selectedConversation" :conversation="selectedConversation" />

            <messages v-if="selectedConversation" :conversation="selectedConversation" />

            <compose-message v-if="selectedConversation" :conversation="selectedConversation" />

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

        <properties v-if="selectedConversation" :visitor_id="selectedConversation.visitor_id" />
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
        }
    }
</script>
