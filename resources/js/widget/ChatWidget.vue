<template>
    <div class="chat-container">
        <div v-if="showConversation" class="chat-conversation">
            <div class="chat-conversation-toolbar rounded-t-lg text-white font-bold">
                <div class="flex-1 p-2">
                    Jack from WeRoster
                </div>
                <div @click="toggleConversation()" class="text-white p-2 cursor-pointer">
                    <i class="fa fa-fw fa-times"></i>
                </div>
            </div>

            <div ref="chat-conversation" class="chat-conversation-content">
                <div v-for="message in messages" class="chat-message" :class="message.sender == 'me' ? 'chat-message-sent' : 'chat-message-received'">
                    {{ message.message }}
                </div>
            </div>

            <form class="chat-conversation-messagebar flex p-3">
                <div class="flex-1 mr-2">
                    <input type="text" v-model="message" class="c-input" placeholder="Type message..." />
                </div>
                <button @click.prevent="sendMessage()" :disabled="message == ''" class="c-button">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <div @click="toggleConversation()" class="chat-bubble cursor-pointer">
            <div class="flex-1 text-center text-4xl">
                <i v-if="showConversation" class="fa fa-fw fa-times"></i>
                <i v-if="!showConversation" class="fa fa-fw fa-support"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                showConversation: true,
                message: '',
                messages: [
                    {
                        sender: 'Jack',
                        message: 'Hi! How can I help you today?'
                    },
                    {
                        sender: 'me',
                        message: 'Hi, I\'m running into an issue when I try to do something.'
                    },
                    {
                        sender: 'Jack',
                        message: 'No worries, what\'s the issue?'
                    },
                    {
                        sender: 'me',
                        message: 'Seems to be that when I try to publish the roster I get the spinning loading icon then nothing after that.'
                    },
                    {
                        sender: 'Jack',
                        message: 'Are there any error messages that popup? And does the loading icon eventually go away?'
                    },
                    {
                        sender: 'me',
                        message: 'Nope and nope. Only when I reload the page does it go away.'
                    },
                    {
                        sender: 'Jack',
                        message: 'Hmm, I\'ll check on this now and get back to you in a couple of minutes if that\'s ok.'
                    },
                    {
                        sender: 'me',
                        message: 'Yep that\'s all good in the hood.'
                    },
                ],
            }
        },

        computed: {
            //
        },

        methods: {
            sendMessage() {
                this.messages.push({
                    sender: 'me',
                    message: this.message,
                })

                this.message = ''

                this.scrollToBottom()
            },
            toggleConversation() {
                this.showConversation = !this.showConversation

                this.scrollToBottom()
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    if (this.$refs['chat-conversation']) {
                        this.$refs['chat-conversation'].scroll(0, 9999)
                    }
                })
            },
        }
    }
</script>

<style lang="scss">
    .c-input {
        @apply .px-3 .py-2 .border-2 .w-full;
    }
    .c-button {
        @apply .border-2;
    }

    .chat-container {
        @apply .fixed .pin-r .pin-b .p-6;

        .chat-message {
            @apply .my-2 .px-2 .py-1;
            @apply .rounded-lg;
        }
        .chat-message-received {
            @apply .text-left .mr-8 .bg-green .text-white;
        }
        .chat-message-sent {
            @apply .text-right .ml-8 .bg-grey-light;
        }

        .chat-conversation {
            @apply .mb-3;
            @apply .rounded-lg .bg-white .shadow-md;

            .chat-conversation-toolbar {
                @apply .bg-green .flex .shadow;
            }
            .chat-conversation-content {
                width: 300px;
                height: 400px;
                @apply .px-3 .mb-3 .overflow-y-scroll;
            }
            .chat-conversation-messagebar {
                @apply .flex;
            }
        }

        .chat-bubble {
            line-height: 1em;
            @apply .float-right;
            @apply .flex .items-center .w-16 .h-16 .rounded-full;
            @apply .bg-green .text-white .shadow;
        }
    }
</style>
