<template>
    <div class="mx-3 my-2 flex items-end" :class="message.from_user_id === 1 ? 'justify-end' : ''">
        <img v-if="!message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-10 h-10 m-2 rounded-full" />

        <div class="w-3/4 inline-block m-2 p-3 rounded-lg"
            :class="message.from_user_id === 1 ? 'bg-green text-white' : 'bg-grey-lighter'">
            {{ message.message | nl2br }}
        </div>

        <img v-if="message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-10 h-10 m-2 rounded-full" />
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                //
            }
        },

        computed: {
            //
        },

        methods: {
            //
        }
    }
</script>
