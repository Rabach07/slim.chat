<template>
    <div class="h-screen flex flex-col overflow-y-scroll">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">Data</h1>
        </div>

        <div class="overflow-y-scroll h-full p-4">
            <form>
                <div class="flex">
                    <div class="group flex-1">
                        <label>Fixed Properties</label>
                        <select v-model="fixedPropertiesSelected" class="input" size="7" multiple>
                            <option v-for="property in fixedProperties">
                                {{ property }}
                            </option>
                        </select>
                        <p>Will show at the top of property lists.</p>
                    </div>
                    <div class="px-6 self-center">
                        <div class="my-6 text-center">
                            <button @click="add()" type="button" class="button w-full" :class="availablePropertiesSelected.length ? 'green' : 'white'">
                                <i class="fa fa-fw fa-arrow-left"></i> Fix Property
                            </button>
                        </div>

                        <div class="my-6 text-center">
                            <button @click="remove()" type="button" class="button w-full" :class="fixedPropertiesSelected.length ? 'red' : 'white'">
                                <i class="fa fa-fw fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="group flex-1">
                        <label>Available Properties</label>
                        <input v-model="availablePropertiesSearch" type="text" class="input mb-2" placeholder="Search properties...">
                        <select v-model="availablePropertiesSelected" class="input" size="5" multiple>
                            <option v-for="property in availablePropertiesFiltered">
                                {{ property }}
                            </option>
                        </select>
                        <p>All the available properties.</p>
                    </div>
                </div>

                <div class="actions">
                    <button @click.prevent="saveSettings()" class="button green">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    var filter = require('lodash/filter')
    var uniqBy = require('lodash/uniqBy')

    export default {
        props: [''],

        data() {
            return {
                fixedProperties: [],
                fixedPropertiesSelected: [],
                availablePropertiesSearch: '',
                availableProperties: [],
                availablePropertiesSelected: [],
            }
        },

        computed: {
            availablePropertiesFiltered() {
                return filter(this.availableProperties, property => {
                    return String(property).toLowerCase().includes(this.availablePropertiesSearch.toLowerCase())
                })
            }
        },

        methods: {
            add() {
                this.fixedProperties = this.fixedProperties.concat(this.availablePropertiesSelected)
                this.fixedProperties = uniqBy(this.fixedProperties, property => property)
                this.availablePropertiesSelected = []
            },
            remove() {
                this.fixedProperties = this.fixedProperties.filter(property => {
                    return ! this.fixedPropertiesSelected.includes(property)
                })
                this.fixedPropertiesSelected = []
            },
            fetchSettings() {
                axios.get('/api/businesses/1/settings/fixed_properties')
                .then(response => {
                    this.fixedProperties = response.data ? response.data.split(',') : []
                })
            },
            fetchProperties() {
                axios.get('/api/businesses/' + this.$root.business.id + '/properties')
                .then(response => {
                    this.availableProperties = response.data.data.sort()
                })
            },
            saveSettings() {
                axios.post('/api/businesses/1/settings/fixed_properties', {
                    value: this.fixedProperties.join(',')
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            }
        },

        created() {
            this.fetchSettings()
            this.fetchProperties()
        }
    }
</script>
