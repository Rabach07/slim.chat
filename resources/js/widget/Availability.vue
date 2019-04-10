<template>
    <span class="text-xs pl-1 pr-2 py-1 bg-white text-grey-darker rounded-full">
        <span v-if="availability.status == 'online'">
            <i  class="fa fa-fw fa-circle text-green"></i>
            {{ availability.message }}
        </span>
        <span v-if="availability.status == 'offline'">
            <i  class="fa fa-fw fa-circle text-grey"></i>
            {{ availability.message }}
        </span>
        <span v-if="availability.status == 'away'">
            <i  class="fa fa-fw fa-circle text-grey"></i>
            {{ availability.message }}
        </span>
    </span>
</template>

<script>
    export default {
        props: ['timezone'],

        data() {
            return {
                availability: {}
            }
        },

        methods: {
            fetchAvailability() {
                axios.get('/api/businesses/' + this.$root.business.id + '/availability')
                .then(response => {
                    this.availability = response.data.data
                })
            }
        },

        created() {
            this.fetchAvailability()
        }
    }
</script>
