<template>
    <div class="flex flex-col h-screen">
        <div class="flex-no-stretch border-b">
            <input v-model="conversationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
        </div>
        <div class="flex border-b text-grey-darker select-none">
            <div class="flex-1 p-2 pr-1">
                <select v-model="filters.status" class="input">
                    <optgroup label="Status">
                        <option v-for="status in statuses">{{ status }}</option>
                    </optgroup>
                </select>
            </div>
            <div class="flex-1 p-2 pl-1">
                <select v-model="filters.order" class="input">
                    <optgroup label="Sort">
                        <option v-for="order in orders">{{ order }}</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="overflow-y-scroll" style="height: calc(100vh - 65px - 53px);">
            <conversation v-for="conversation in conversationsFiltered"
                :key="'conversation'+conversation.id"
                :conversation="conversation"
                :class="selectedConversation.id == conversation.id ? 'bg-grey-lighter' : ''"
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
                selectedConversation: {},
                conversations: [],
                statuses: ['Closed', 'Open'],
                orders: ['Recent', 'Newest', 'Oldest'],
                filters: {
                    status: 'Open',
                    order: 'Recent'
                }
            }
        },

        watch: {
            filters: {
                handler(newVal, oldVal) {
                    this.fetchConversations()
                },
                deep: true
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
                axios.get('/api/conversations', {
                    params: {
                        'filter[status]': this.statuses.indexOf(this.filters.status),
                        'sort': this.filters.order == 'Recent' ? '-updated_at' : this.filters.order == 'Newest' ? '-created_at' : 'created_at',
                        business_id: this.$root.business.id
                    }
                })
                .then(response => {
                    this.conversations = response.data.data
                })
            }
        },

        created() {
            this.fetchConversations()

            this.$bus.$on('conversationSelected', conversation => {
                this.selectedConversation = conversation
            })

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
