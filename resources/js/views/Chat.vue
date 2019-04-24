<template>
    <div class="flex h-screen overflow-hidden">
        <div class="w-1/5 border-r">
            <div class="border-b p-4 mt-4">
                <div class="flex items-baseline">
                    <h1 class="mb-0">Conversations</h1>
                </div>
            </div>

            <conversations />
        </div>

        <div class="flex-1 h-screen flex flex-col border-r">
            <conversation-detail v-if="selectedConversation.id" :conversation="selectedConversation" />

            <messages v-if="selectedConversation.id" :conversation="selectedConversation" />

            <compose-message v-if="selectedConversation.id && selectedConversation.status == 1" :conversation="selectedConversation" />

            <div v-if="!selectedConversation.id" class="h-full flex items-center w-3/4 mx-auto text-center select-none">
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
            <properties v-if="selectedConversation.id" :visitor_id="selectedConversation.visitor_id" />
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
                selectedConversation: {},
            }
        },

        created() {
            this.$bus.$on('conversationSelected', conversation => {
                this.selectedConversation = conversation
            })
        }
    }
</script>
