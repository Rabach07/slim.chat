<template>
    <div class="h-screen overflow-y-scroll">
        <div class="border-b p-4 mt-4">
            <h1 class="mb-0">Team</h1>
        </div>

        <div class="p-4">
            <div class="flex border-b">
                <div>
                    <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200" class="block w-8 h-8 m-2 rounded-full" />
                </div>
                <div class="flex-1 self-center">
                    Jack Cruden
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                team: [],
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
