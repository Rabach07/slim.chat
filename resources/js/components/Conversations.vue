<template>
    <div class="h-screen">
        <div class="border-b">
            <input v-model="conversationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
        </div>
        <div class="border-b text-grey-darker select-none">
            <div class="flex p-2">
                <span class="text-lg py-2 pr-2">Status</span>
                <select v-model="selectedStatus" class="input">
                    <option v-for="status in statuses">{{ status }}</option>
                </select>
            </div>
        </div>
        <div class="overflow-y-scroll" style="height: calc(100vh - 65px - 53px);">
            <conversation v-for="conversation in conversationsFiltered"
                :key="'conversation'+conversation.id"
                @selected="selected(conversation)"
                :conversation="conversation"
                :class="selectedConversation == conversation ? 'bg-grey-lighter' : ''"
            />

            <div v-if="!conversationsFiltered.length" class="p-4 text-center select-none text-grey">
                No conversations to show.
            </div>
        </div>
    </div>
</template>

<script>
    var sortBy = require('lodash/sortBy')
    var filter = require('lodash/filter')

    import Conversation from './../components/Conversation'

    export default {
        components: { Conversation },

        data() {
            return {
                conversationSearch: '',
                selectedConversation: null,
                conversations: [],
                selectedStatus: 'Open',
                statuses: ['Closed', 'Open']
            }
        },

        watch: {
            selectedStatus(newVal, oldVal) {
                this.fetchConversations()
            }
        },

        computed: {
            conversationsFiltered() {
                return filter(this.conversations, conversation => {
                    return conversation.name.toLowerCase().includes(this.conversationSearch.toLowerCase())
                })
            }
        },

        methods: {
            fetchConversations() {
                axios.get('/api/conversations?filter[status]=' + this.statuses.indexOf(this.selectedStatus), {
                    params: {
                        business_id: this.$root.business.id
                    }
                })
                .then(response => {
                    this.conversations = response.data.data
                })
            },
            selected(conversation) {
                this.selectedConversation = conversation

                this.$emit('selected', conversation)
            }
        },

        created() {
            this.fetchConversations()

            Echo.channel('businesses.' + this.$root.business.id + '.conversations')
            .listen('ConversationUpdated', event => {
                this.fetchConversations()
            })
        },

        beforeDestroyed() {
            Echo.leave('businesses.' + this.$root.business.id + '.conversations')
        },
    }
</script>
