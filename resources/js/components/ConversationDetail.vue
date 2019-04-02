<template>
    <div class="flex-no-shrink flex items-center p-2 border-b">
        <div class="flex-1">
            <h2 class="m-0">{{ conversation.name }}</h2>
        </div>

        <div>
            <button v-if="conversation.status == 0" @click="open()" class="button white">
                <i class="fa fa-fw fa-redo-alt"></i> Reopen
            </button>
            <button v-if="conversation.status == 1" @click="close()" class="button white">
                <i class="fa fa-fw fa-check"></i> Close
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation'],

        data() {
            return {
                //
            }
        },

        computed: {
            //
        },

        methods: {
            close() {
                axios.patch('/api/conversations/' + this.conversation.id, {
                    status: 0 // Closed
                })
                .then(response => {
                    this.$emit('selected', null)
                })
            },
            open() {
                axios.patch('/api/conversations/' + this.conversation.id, {
                    status: 1 // Open
                })
                .then(response => {
                    this.$emit('selected', this.conversation)
                })
            }
        }
    }
</script>
