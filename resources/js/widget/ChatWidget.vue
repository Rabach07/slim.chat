<template>
    <div class="c-container">
        <div v-if="showConversation" class="c-conversation">
            <div class="c-conversation-toolbar">
                <div class="c-conversation-toolbar-title">
                    Jack from WeRoster
                </div>
                <div @click="toggleConversation()" class="text-white p-2 cursor-pointer">
                    <i class="fa fa-fw fa-times"></i>
                </div>
            </div>

            <div ref="c-conversation" class="c-conversation-content">
                <div v-for="message in messages" class="c-message" :class="message.sender == 'me' ? 'c-message-sent' : 'c-message-received'">
                    {{ message.message }}
                </div>
            </div>

            <form class="c-conversation-messagebar flex p-3">
                <div class="flex-1 mr-2">
                    <input type="text" v-model="message" class="c-input" maxlength="1024" placeholder="Type message..." />
                </div>
                <button @click.prevent="sendMessage()" :disabled="message == ''" class="c-button">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <div @click="toggleConversation()" class="c-bubble cursor-pointer">
            <div class="flex-1 text-center text-4xl">
                <i v-if="showConversation" class="fas fa-fw fa-times"></i>
                <i v-else class="fas fa-fw fa-life-ring"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['app_id', 'visitor_id'],

        data() {
            return {
                showConversation: false,
                message: '',
                messages: [],
                conversation: {},
            }
        },

        computed: {
            activeConversation() {
                // return conversations[0];
            }
        },

        methods: {
            toggleConversation() {
                this.showConversation = !this.showConversation
                this.scrollToBottom()
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    if (this.$refs['c-conversation']) {
                        this.$refs['c-conversation'].scroll(0, 9999)
                    }
                })
            },
            sendMessage() {
                axios.post('/api/messages', {
                    app_id: this.app_id,
                    visitor_id: this.visitor_id,
                    message: this.message,
                })
                .then(response => {
                    this.message = ''
                })
            },
            fetchConversations() {
                axios.get('/api/conversations', { params: {
                    app_id: this.app_id,
                    visitor_id: this.visitor_id
                }})
                .then(response => {
                    this.conversation = response.data
                })
            }
        },

        created() {
            console.log('ChatWidget created.')

            Echo.channel('conversations.1')
            .listen('NewMessage', event => {
                this.messages.push(event.message)
                this.scrollToBottom()
            })
        },

        destroyed() {
            console.log('ChatWidget destroyed.')

            Echo.leave('conversations.1');
        }
    }
</script>

<style lang="scss" scoped>
    .c-input {
        padding: 0.5rem 0.75rem;
        border: 2px solid lightgrey;
        width: 100%;
        border-radius: 5px;
    }
    .c-button {
        border: 2px solid darkgreen;
        background-color: green;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 5px;
    }

    .c-container {
        position: fixed;
        right: 0;
        bottom: 0;
        padding: 1.5rem;

        font-family: 'Avenir', sans-serif;
        font-size: 1rem;

        .c-message {
            margin: 0.5rem 0;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
        }
        .c-message-received {
            text-align: left;
            margin-right: 2rem;
            background-color: green;
            color: white;
        }
        .c-message-sent {
            text-align: right;
            margin-left: 2rem;
            background-color: lightgrey;
        }

        .c-conversation {
            margin-bottom: 0.75rem;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12),
            0 2px 4px 0 rgba(0,0,0,0.08);

            .c-conversation-toolbar {
                background-color: green;
                display: flex;
                box-shadow: 0 2px 4px 0 rgba(0,0,0,0.10);
                border-radius: 5px 5px 0 0;
                color: white;
                font-weight: bold;
                .c-conversation-toolbar-title {
                    flex: 1;
                    padding: 0.5rem;
                }
            }
            .c-conversation-content {
                width: 300px;
                max-height: 200px;
                padding: 0 0.75rem;
                overflow-y: scroll;
            }
            .c-conversation-messagebar {
                border-top: 1px solid lightgrey;
                display: flex;
            }
        }

        .c-bubble {
            line-height: 1em;
            float: right;
            display: flex;
            align-items: center;
            width: 4rem;
            height: 4rem;
            border-radius: 9999px;
            background-color: green;
            color: white;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.10);
        }
    }
</style>
