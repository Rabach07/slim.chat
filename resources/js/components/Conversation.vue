<template>
    <div ref="c-conversation" class="overflow-y-scroll h-full">
        <div v-for="message in messages" class="mx-3 my-2 flex items-end" :class="message.from_user_id === 1 ? 'justify-end' : ''">
            <img v-if="!message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-10 h-10 m-2 rounded-full" />

            <div class="w-3/4 inline-block m-2 p-3 rounded-lg" :class="message.from_user_id === 1 ? 'bg-green text-white' : 'bg-grey-lighter'">
                {{ message.message }}
            </div>

            <img v-if="message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-10 h-10 m-2 rounded-full" />
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation'],

        data() {
            return {
                message: '',
                messages: [],
            }
        },

        watch: {
            conversation(newId, oldId) {
                this.fetchMessages()
            }
        },

        methods: {
            scrollToBottom() {
                this.$nextTick(() => {
                    if (this.$refs['c-conversation']) {
                        this.$refs['c-conversation'].scroll(0, 9999)
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
                    this.messages = response.data.data

                    this.scrollToBottom()
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

