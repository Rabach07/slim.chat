<template>
    <div @click="selected(conversation)" class="w-full p-4 border-b hover:bg-grey-lighter cursor-pointer select-none">
        <div class="flex items-center">
            <div class="flex-1">
                {{ conversationUpdated.name }}
            </div>
            <div class="float-right select-none" :class="true ? 'text-green' : 'text-grey'">
                <i class="fas fa-circle"></i>
            </div>
        </div>
        <div class="w-full mt-2 flex text-sm">
            <div class="flex-1 truncate">
                "{{ conversationUpdated.most_recent_message.message }}"
            </div>
            <div class="ml-4 text-grey-dark">
                <ago :datetime="conversationUpdated.last_active" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation'],

        data() {
            return {
                conversationUpdated: this.conversation
            }
        },

        methods: {
            selected(conversation) {
                this.selectedConversation = conversation

                this.$emit('selected', conversation)
            },
            fetchConversation() {
                axios.get('/api/conversations/' + this.conversation.id)
                .then(response => {
                    this.conversationUpdated = response.data.data
                })
            }
        },

        created() {
            Echo.channel('conversations.' + this.conversation.id)
            .listen('NewMessage', event => {
                this.fetchConversation()
            })
        },

        beforeDestroyed() {
            Echo.leave('conversations.' + this.conversation.id)
        }
    }
</script>
