<template>
    <div class="flex-1 flex flex-col border-4 rounded-lg overflow-hidden hover:border-green cursor-pointer">
        <div class="flex-1 p-2">
            <h3 class="m-0">{{ automation.name }}</h3>
        </div>
        <div class="flex bg-grey-light p-2 pb-1">
            <div v-if="automation.active" class="flex-1 text-green font-bold">
                <i class="fas fa-circle"></i> Active
            </div>
            <div v-if="!automation.active" class="flex-1 font-bold">
                <i class="fas fa-circle"></i> Inactive
            </div>

            <div class="flex">
                <div class="ml-4">
                    <i class="fas fa-hand-pointer"></i> 43
                </div>
                <div class="ml-4">
                    <i class="fas fa-eye"></i> 24
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['automation'],

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
