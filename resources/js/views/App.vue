<template>
    <div class="flex h-screen">
        <navigation />

        <!-- Left -->
        <div class="w-1/5 border-r h-screen">
            <div class="border-b">
                <input v-model="conversationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
            </div>
            <div class="overflow-y-scroll" style="height: calc(100vh - 65px);">
                <div v-for="conversation in conversationsFiltered" class="flex items-center p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <div class="flex-1" :class="conversation.read && 'font-bold'">
                        {{ conversation.user.name }}
                    </div>
                    <div class="float-right select-none" :class="conversation.user.active ? 'text-green' : 'text-grey'">
                        <i v-if="conversation.user.active" class="fas fa-circle"></i>
                        <span v-if="!conversation.user.active">
                            {{ conversation.user.last_active }}
                        </span>
                    </div>
                </div>
                <div v-if="!conversationsFiltered.length" class="p-4 text-center select-none text-grey">
                    No conversations found.
                </div>
            </div>
        </div>

        <!-- Middle -->
        <div class="flex-1">
            <div class="overflow-y-scroll" style="height: calc(100vh - 113px)">
                <div class="mx-3 my-2 flex items-end">
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />

                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-grey-lighter">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>
                </div>

                <div class="mx-3 my-2 flex items-end justify-end">
                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-green text-white">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>

                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />
                </div>

                <div class="mx-3 my-2 flex items-end">
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />

                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-grey-lighter">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>
                </div>

                <div class="mx-3 my-2 flex items-end justify-end">
                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-green text-white">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>

                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />
                </div>

                <div class="mx-3 my-2 flex items-end">
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />

                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-grey-lighter">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>
                </div>

                <div class="mx-3 my-2 flex items-end justify-end">
                    <div class="w-3/4 inline-block m-2 p-3 rounded-lg bg-green text-white">
                        This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message. This is a long message.
                    </div>

                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-12 h-12 m-2 rounded-full" />
                </div>
            </div>
            <div class="flex border-t p-2">
                <div class="flex-1">
                    <textarea class="block input focus:outline-none w-full p-4 leading-loose" rows="2" placeholder="Type message...">
                    </textarea>
                </div>
                <div class="pl-2">
                    <button class="button green">
                        Send
                    </button>
                </div>
            </div>
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
    var sortBy = require('lodash/sortBy')
    var filter = require('lodash/filter')

    export default {
        props: [''],

        data() {
            return {
                conversationSearch: '',
            }
        },

        computed: {
            conversations() {
                let conversations = []
                for (let i = 0; i < 20; i++) {
                    let lastActive = Math.max(Math.round(Math.random()*10-2), 0)

                    conversations.push({
                        user: {
                            name: this.random(),
                            last_active: lastActive + 'm',
                            active: lastActive == 0 ? true : false,
                        },
                        read: lastActive == 0 ? true : false,
                    })
                }
                return sortBy(conversations, 'user.last_active')
            },
            conversationsFiltered() {
                return filter(this.conversations, conversation => {
                    return conversation.user.name.toLowerCase().includes(this.conversationSearch.toLowerCase())
                })
            }
        },

        methods: {
            random() {
                return Math.random().toString(36).slice(2)
            },
        },

        mounted() {
            console.log('App.vue ready.')
        }
    }
</script>
