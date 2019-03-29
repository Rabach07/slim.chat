<template>
    <div ref="c-conversation" class="overflow-y-scroll h-full">
        <message v-for="message in messages" :key="'message'+message.id" :message="message" />
    </div>
</template>

<script>
    import Message from './../components/Message'

    export default {
        components: { Message },

        props: ['conversation'],

        data() {
            return {
                message: '',
                messages: [],
            }
        },

        watch: {
            conversation: {
                immediate: true,
                handler(newConversation, oldConversation) {
                    if (oldConversation) {
                        Echo.leave('conversations.' + oldConversation.id)
                    }

                    Echo.channel('conversations.' + newConversation.id)
                    .listen('NewMessage', event => {
                        this.messages.push(event.message)
                        this.scrollToBottom(true)
                    })

                    this.fetchMessages()
                }
            }
        },

        methods: {
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
            fetchMessages() {
                axios.get('/api/messages/', {
                    params: {
                        conversation_id: this.conversation.id
                    }
                })
                .then(response => {
                    this.messages = response.data.data.reverse()

                    this.scrollToBottom()
                })
            }
        },

        beforeDestroyed() {
            Echo.leave('conversations.' + this.conversation.id)
        }
    }
</script>

