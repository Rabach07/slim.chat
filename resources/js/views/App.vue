<template>
    <div class="flex h-screen">
        <navigation />

        <!-- Left -->
        <conversations @selected="conversationSelected" />

        <!-- Middle -->
        <div class="flex-1">
            <conversation :conversation_id="selectedConversation" />

            <compose-message v-if="selectedConversation" :conversation_id="selectedConversation" />
        </div>

        <!-- Right -->
        <div class="w-1/5 border-l h-screen">
            <div class="overflow-y-scroll h-screen">
                <div class="p-4 border-b text-center select-none">
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200"
                        class="w-24 h-24 rounded-full" /><br>

                    <div class="font-bold mt-3 text-lg">Jack Cruden</div>
                </div>
                <div class="flex items-center p-4 border-b">
                    <div class="flex-1 truncate">jackcruden@gmail.com</div>
                    <div class="float-right select-none text-grey">
                        <i class="fas fa-at"></i>
                    </div>
                </div>
                <div class="flex items-center p-4 border-b">
                    <div class="flex-1 truncate">Taranaki, New Zealand</div>
                    <div class="float-right select-none text-grey">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <div class="flex items-center p-4 border-b">
                    <div class="flex-1 truncate">9:05pm, 28th February</div>
                    <div class="float-right select-none text-grey">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="flex items-center p-4 border-b">
                    <div class="flex-1 truncate">Chrome 72, MacBook Pro</div>
                    <div class="float-right select-none text-grey">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>

                <div class="flex items-center border-b-2"></div>

                <div class="items-center p-4 border-b">
                    <div class="mb-2 text-xs text-grey font-semibold uppercase truncate select-none">
                        Number of Stores
                    </div>
                    <div class="truncate">
                        4
                    </div>
                </div>
                <div class="items-center p-4 border-b">
                    <div class="mb-2 text-xs text-grey font-semibold uppercase truncate select-none">
                        Number of staff
                    </div>
                    <div class="truncate">
                        23
                    </div>
                </div>
                <div class="items-center p-4 border-b">
                    <div class="mb-2 text-xs text-grey font-semibold uppercase truncate select-none">
                        Member since
                    </div>
                    <div class="truncate">
                        4th April 2017
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Conversations from './../components/Conversations'
    import Conversation from './../components/Conversation'
    import ComposeMessage from './../components/ComposeMessage'

    export default {
        components: {
            Conversations,
            Conversation,
            ComposeMessage
        },

        props: [''],

        data() {
            return {
                selectedConversation: null,
            }
        },

        methods: {
            conversationSelected(event) {
                this.selectedConversation = event
            }
        },

        mounted() {
            console.log('App.vue ready.')
        }
    }
</script>
