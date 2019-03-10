<template>
    <div class="flex-no-shrink flex border-t p-2">
        <div class="flex-1">
            <textarea ref="compose-message-input" v-model="message" @keydown.meta.enter.exact.prevent="sendMessage()"
                class="input block leading-normal" placeholder="Type message...">
            </textarea>
        </div>
        <div class="pl-2">
            <button @click="sendMessage()" class="button green h-full">
                Send<br>
                <span class="text-xs">&#8984; + Enter</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation'],

        data() {
            return {
                message: '',
            }
        },

        watch: {
            message(newMessage, oldMessage) {
                this.setInputHeight()
            }
        },

        methods: {
            sendMessage() {
                axios.post('/api/messages/', {
                    conversation_id: this.conversation.id,
                    message: this.message,
                })
                .then(response => {
                    this.message = ''
                    this.setInputHeight()
                })
            },
            setInputHeight() {
                this.$nextTick(() => {
                    this.$refs['compose-message-input'].style.height = '70px'
                    let height = this.$refs['compose-message-input'].scrollHeight
                    height = Math.min(Math.max(height, 70), 200)
                    this.$refs['compose-message-input'].style.height = (height + 8) + 'px'
                })
            }
        }
    }
</script>
