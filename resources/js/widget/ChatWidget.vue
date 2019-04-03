<template>
    <div v-if="showConversation" class="sc-window"
        :style="'--primary: '+settings.colors.primary+';'+'--contrast: '+settings.colors.contrast+';'">
        <div class="flex px-3 flex-no-shrink items-center text-white font-bold border-b-2 border-black-10 select-none"
            style="background-color: var(--primary);">
            <div v-if="conversation" @click="closeConversation()" class="mr-3 px-2 py-4 text-xl content-end cursor-pointer hover:bg-black-20 rounded">
                <i class="fa fa-chevron-left"></i>
            </div>
            <div class="flex-1 flex items-center">
                <img :src="settings.logo" onerror="this.src='/images/utility/image.png'" class="w-16 h-16 rounded-full border-white" />
                <div class="p-3">
                    <div class="text-2xl text-contrast">WeRoster</div>
                    <span class="text-xs pl-1 pr-2 py-1 bg-white text-grey-darker rounded-full">
                        <i class="fa fa-fw fa-circle text-green"></i>
                        Online
                    </span>
                </div>
            </div>
        </div>

        <div ref="c-conversation" class="overflow-y-scroll h-full">
            <message v-for="message in messages" :key="'message' + message.id" :message="message" />

            <div v-if="!conversation" class="m-3 rounded-lg overflow-hidden shadow-lg">
                <div class="flex px-3 py-2 text-sm text-grey-dark border-b-2 bg-grey-lighter select-none">
                    <div class="flex-1 font-bold">
                        Conversations
                    </div>
                    <div class="underline">View All</div>
                </div>

                <div v-for="conversation in conversations" @click="setConversation(conversation)" class="sc-conversation flex items-center text-sm">
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-8 h-8 m-1 ml-3 rounded-full" />
                    <div class="sc-conversation-subject flex-1 p-2 truncate">
                        <span class="text-grey-dark">"</span>{{ conversation.subject }}<span class="text-grey-dark">"</span>
                    </div>
                    <div class="float-right px-3 py-2 text-grey">
                        {{ conversation.updated_at | ago }}
                    </div>
                </div>
            </div>
        </div>

        <form class="sc-messagebar">
            <div class="flex-1 mr-2">
                <input type="text" v-model="messageInput" class="sc-input" maxlength="1024" placeholder="Type to start a conversation..." />
            </div>
            <button @click.prevent="sendMessage()" :disabled="messageInput == ''" class="sc-button text-contrast">
                <i class="fa fa-paper-plane"></i>
            </button>
        </form>
    </div>
</template>

<script>
    import Message from './Message'

    export default {
        components: { Message },

        props: ['app_id', 'visitor_uuid', 'settings', 'show'],

        data() {
            return {
                showConversation: this.show,
                conversations: [],
                conversation: null,
                messages: [],
                messageInput: ''
            }
        },

        methods: {
            toggleConversation(show = null) {
                if (show != null) {
                    this.showConversation = show
                } else {
                    this.showConversation = !this.showConversation
                }

                this.scrollToBottom()

                window.parent.postMessage({
                    to: 'parent',
                    data: {
                        width: this.showConversation ? '350px' : '0',
                        height: this.showConversation ? '500px': '0'
                    }
                })
            },
            scrollToBottom(smooth) {
                this.$nextTick(() => {
                    if (this.$refs['c-conversation']) {
                        this.$refs['c-conversation'].scroll({
                            top: 99999999,
                            behavior: smooth ? 'smooth' : 'auto'
                        })
                    }
                })
            },
            sendMessage() {
                if (this.conversation) {
                    this.postMessage(this.messageInput)
                    this.messageInput = ''
                } else {
                    // Create conversation
                    axios.post('/api/conversations', {
                        app_id: this.app_id,
                        visitor_uuid: this.visitor_uuid
                    })
                    .then(response => {
                        this.conversation = response.data.data
                        this.fetchConversations()

                        this.postMessage(this.messageInput)
                        this.messageInput = ''
                    })
                }
            },
            postMessage(messageInput) {
                axios.post('/api/messages', {
                    app_id: this.app_id,
                    visitor_uuid: this.visitor_uuid,
                    conversation_id: this.conversation.id,
                    message: messageInput,
                })
                .then(response => {
                    // Message sent
                })
            },
            closeConversation() {
                this.conversation = null
                this.messages = []
            },
            setConversation(conversation) {
                this.conversation = conversation
                this.fetchMessages()

                if (this.conversation) {
                    Echo.leave('conversations.' + this.conversation.id)
                }

                Echo.channel('conversations.' + this.conversation.id)
                .listen('NewMessage', event => {
                    this.messages.push(event.message)
                    this.scrollToBottom(true)
                    this.$sounds.message.play()
                })
            },
            fetchConversations() {
                axios.get('/api/conversations', {
                    params: {
                        app_id: this.app_id,
                        visitor_uuid: this.visitor_uuid,
                        limit: 3
                    }
                })
                .then(response => {
                    this.conversations = response.data.data
                })
            },
            fetchMessages() {
                axios.get('/api/messages', {
                    params: {
                        visitor_uuid: this.visitor_uuid,
                        conversation_id: this.conversation.id
                    }
                })
                .then(response => {
                    this.messages = response.data.data.reverse()

                    this.scrollToBottom()
                })
            }
        },

        created() {
            console.log('ChatWidget created.')

            this.fetchConversations()

            // window.addEventListener('message', message => {
            //     this.toggleConversation(message.data.open)
            // }, false)
        },

        destroyed() {
            console.log('ChatWidget destroyed.')

            // if (this.conversation) {
            //     Echo.leave('conversations.' + this.conversation.id)
            // }

            // window.removeEventListener('message',)
        },
    }
</script>

<style lang="scss">
    .sc-window {
        @apply .flex-1 .h-full .flex .flex-col;
        @apply .bg-white .leading-normal .text-base;
    }
    .sc-input {
        @apply .p-2 .w-full .rounded;
        @apply .border-2;
        &:focus {
            @apply .outline-none .border-primary;
        }
    }
    .sc-button {
        @apply .px-3 .py-2 .text-white .border-2 .rounded;
        @apply .bg-primary .border-black-10;
    }
    .sc-conversation {
        @apply .border-b .cursor-pointer;
        &:hover {
            @apply .bg-grey-lightest;
        }
    }
    .sc-conversation-subject {

    }
    .sc-messagebar {
        @apply .flex .flex-no-shrink .p-3 .border-t-2 .bg-grey-lightest;
    }
</style>
