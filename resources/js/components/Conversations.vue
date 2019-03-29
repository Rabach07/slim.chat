<template>
    <div class="h-full border-r">
        <div class="border-b">
            <input v-model="conversationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
        </div>
        <div class="overflow-y-scroll">
            <conversation v-for="conversation in conversationsFiltered"
                :key="'conversation'+conversation.id"
                @selected="selected(conversation)"
                :conversation="conversation"
                :class="selectedConversation == conversation ? 'bg-grey-lighter' : ''"
            />

            <div v-if="!conversationsFiltered.length" class="p-4 text-center select-none text-grey">
                No conversations found.
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

        props: [''],

        data() {
            return {
                conversationSearch: '',
                selectedConversation: null,
                conversations: [],
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
                        business_id: this.$business.id
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
        }
    }
</script>
