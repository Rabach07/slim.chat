<template>
    <div class="w-1/5 border-r h-screen">
        <div class="border-b">
            <input v-model="conversationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
        </div>
        <div class="overflow-y-scroll" style="height: calc(100vh - 65px);">
            <div v-for="conversation in conversationsFiltered" @click="selected(conversation)" class="flex items-center p-4 border-b hover:bg-grey-lighter cursor-pointer" :class="selectedConversation == conversation.id ? 'bg-grey-lighter' : ''">
                <div class="flex-1">
                    {{ conversation.name }}
                </div>
                <!-- <div class="float-right select-none" :class="conversation.user.active ? 'text-green' : 'text-grey'">
                    <i v-if="conversation.user.active" class="fas fa-circle"></i>
                    <span v-if="!conversation.user.active">
                        {{ conversation.user.last_active }}
                    </span>
                </div> -->
            </div>
            <div v-if="!conversationsFiltered.length" class="p-4 text-center select-none text-grey">
                No conversations found.
            </div>
        </div>
    </div>
</template>

<script>
    var sortBy = require('lodash/sortBy')
    var filter = require('lodash/filter')

    export default {
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
