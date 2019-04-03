<template>
    <div class="mx-2 flex items-end" :class="!message.from_user_id ? 'justify-end' : ''">
        <img v-if="message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-8 h-8 mb-4 rounded-full" />

        <div class="inline inline-block mx-2 mb-4 px-2 py-1 rounded-lg" style="max-width: 75%;"
            :class="message.from_user_id ? 'bg-grey-lighter' : 'bg-primary text-contrast'">
            {{ message.message }}
        </div>

        <img v-if="!message.from_user_id" src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="w-8 h-8 mb-4 rounded-full" />
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
