<template>
    <div class="flex h-screen">
        <conversations @selected="conversationSelected" />

        <div class="flex-1">
            <conversation :conversation="selectedConversation" />

            <compose-message v-if="selectedConversation" :conversation="selectedConversation" />
        </div>

        <properties v-if="selectedConversation" :visitor_id="selectedConversation.visitor_id" />
    </div>
</template>

<script>
    import Conversations from './../components/Conversations'
    import Conversation from './../components/Conversation'
    import ComposeMessage from './../components/ComposeMessage'
    import Properties from './../components/Properties'

    export default {
        components: {
            Conversations,
            Conversation,
            ComposeMessage,
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
