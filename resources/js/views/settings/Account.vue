<template>
    <div class="h-screen overflow-y-scroll">
        <div class="border-b p-4 mt-4">
            <h1 class="mb-0">Account</h1>
        </div>

        <div class="p-4 xl:w-2/3">
            <form>
                <div class="group">
                    <label>Name</label>
                    <input v-model="business.name" type="text" name="name" class="input">
                    <p>Your business name will be shown publicly.</p>
                </div>

                <div class="group">
                    <label>Timezone</label>
                    <select v-model="settings.timezone" class="input">
                        <option :value="undefined" disabled>Select timezone...</option>
                        <option v-for="timezone in timezones" :value="timezone">{{ timezone }}</option>
                    </select>
                </div>

                <div class="actions">
                    <button @click.prevent="save()" type="submit" class="button green">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                business: {},
                settings: {
                    timezone: this.$root.business.settings.timezone,
                },
                timezones: [],
            }
        },

        computed: {
            //
        },

        methods: {
            fetchTimezones() {
                axios.get('/api/system/timezones')
                .then(response => {
                    this.timezones = response.data.data
                })
            },
            fetchBusiness() {
                axios.get('/api/businesses/' + this.$root.business.id)
                .then(response => {
                    this.business = response.data.data
                })
            },
            save() {
                axios.all([
                    axios.put('/api/businesses/' + this.$root.business.id, {
                        name: this.business.name
                    }),
                    axios.post('/api/businesses/' + this.$root.business.id + '/settings', {
                        settings: {
                            timezone: this.settings.timezone,
                            hours: JSON.stringify(this.settings.hours)
                        }
                    })
                ])
                .then(axios.spread((responseBusiness, responseSettings) => {
                    this.business = responseBusiness.data.data

                    this.$toasted.global.saved()
                }))
            }
        },

        created() {
            this.fetchBusiness()
            this.fetchTimezones()
        }
    }
</script>
