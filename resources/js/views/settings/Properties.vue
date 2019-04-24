<template>
    <div class="h-screen overflow-y-scroll">
        <div class="header">
            <h1>Properties</h1>
        </div>

        <div class="p-4">
            <form class="flex">
                <div class="flex-1">
                    <div class="group">
                        <label>Add Property</label>

                        <div class="actions flex">
                            <div class="flex-1 mr-2">
                                <input type="text" class="input" placeholder="Property name...">
                            </div>
                            <div class="mr-2">
                                <select class="input">
                                    <option>Text</option>
                                    <option>Number</option>
                                    <option>Boolean</option>
                                    <option>Date</option>
                                </select>
                            </div>
                            <div>
                                <button @click="createProperty()" class="button green">
                                    Add Property
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <label>Properties</label>
                        <div class="border-4 rounded-lg">
                            <div class="border-b">
                                <input type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search properties...">
                            </div>

                            <div class="overflow-y-scroll" style="height: 300px;">
                                <table class="table">
                                    <thead class="header-fixed">
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="property in availableProperties">
                                            <td>{{ property.name }}</td>
                                            <td>{{ property.type }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-1/3 ml-4">
                    <div class="alert info">
                        A <strong>Property</strong> is a piece of information about a person. It can be one of four types: text, number, boolean, date.
                    </div>

                    <div class="group">
                        <label><i class="fas fa-quote-left"></i> Text</label>
                        <p>A text property can be anything and is suited for data like 'name', 'email' and 'country'.</p>
                    </div>
                    <div class="group">
                        <label><i class="fas fa-hashtag"></i> Number</label>
                        <p>A number property can be any valid representation of a number, including a negative sign, and decimal points; '43', '-1.23'.</p>
                    </div>
                    <div class="group">
                        <label><i class="fas fa-toggle-on"></i> Boolean</label>
                        <p>A boolean property can simply be 'true' or 'false'.</p>
                    </div>
                    <div class="group">
                        <label><i class="fas fa-calendar-alt"></i> Date</label>
                        <p>The date property is a date and time value.</p>
                    </div>
                </div>
            </form>
        </div>

        <div class="header">
            <h1>Fixed Properties</h1>
        </div>

        <form class="p-4">
            <div class="alert info">
                A <strong>Fixed Property</strong> is a property you want shown above other properties. For example you might set 'name', 'email', and 'country' as fixed properties so they are always visible.
            </div>

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
                            {{ property.name }}
                        </option>
                    </select>
                    <p>All the available properties.</p>
                </div>
            </div>

            <div class="actions">
                <button @click.prevent="saveSettings()" class="button green">
                    Save Fixed Properties
                </button>
            </div>
        </form>
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
                    return String(property.name).toLowerCase().includes(this.availablePropertiesSearch.toLowerCase())
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
                axios.get('/api/businesses/1/settings/properties_fixed')
                .then(response => {
                    this.fixedProperties = response.data.value ? response.data.value.split(',') : []
                })
            },
            fetchProperties() {
                axios.get('/api/businesses/' + this.$root.business.id + '/properties')
                .then(response => {
                    this.availableProperties = response.data.data
                })
            },
            saveSettings() {
                axios.post('/api/businesses/1/settings/properties_fixed', {
                    value: this.fixedProperties.join(',')
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            },
            createProperty() {
                // do it
            }
        },

        created() {
            this.fetchSettings()
            this.fetchProperties()
        }
    }
</script>
