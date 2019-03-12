<template>
    <div class="mx-2 my-1 flex items-end" :class="!message.from_user_id ? 'justify-end' : ''">
        <img v-if="message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-8 h-8 m-2 rounded-full" />

        <div class="w-3/4 inline-block m-2 px-2 py-1 rounded-lg"
            :class="message.from_user_id ? 'bg-grey-lighter' : 'bg-green text-white'">
            {{ message.message }}
        </div>

        <img v-if="!message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-8 h-8 m-2 rounded-full" />
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
