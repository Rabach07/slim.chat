<template>
    <div class="flex border-t p-2">
        <div class="flex-1">
            <textarea v-model="message" @keydown.meta.enter.exact.prevent="sendMessage()"
                class="input block" rows="2" placeholder="Type message...">
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
        props: ['conversation_id'],

        data() {
            return {
                message: '',
            }
        },

        methods: {
            sendMessage() {
                axios.post('/api/messages/', {
                    conversation_id: this.conversation_id,
                    message: this.message,
                })
                .then(response => {
                    this.message = ''
                })
            },
        }
    }
</script>
