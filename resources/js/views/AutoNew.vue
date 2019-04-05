<template>
    <div class="flex flex-col h-screen">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">New Auto</h1>
        </div>

        <div class="flex overflow-y-scroll p-4">
            <div class="w-2/5">
                <form>
                    <div class="group">
                        <div class="group">
                            <label>Match</label>
                            <select class="input">
                                <option>Match all filters</option>
                                <option>Match any filter(s)</option>
                            </select>
                        </div>

                        <label>Filters</label>
                        <div class="group">
                            <div v-for="(filter, index) in filters" class="input flex mb-1">
                                <div class="flex-1">
                                    <span class="bg-grey-lighter px-1 rounded">{{ filter.property }}</span>
                                    <span>{{ filter.condition }}</span>
                                    <span class="bg-grey-lighter px-1 rounded">{{ filter.value }}</span>
                                </div>
                                <div @click="removeFilter(index)" class="ml-1 text-grey cursor-pointer">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>

                            <transition-expand>
                                <div v-if="showNewFilter">
                                    <div class="group border-4 bg-grey-lightest rounded-lg p-4">
                                        <div class="group">
                                            <label>Property</label>
                                            <div v-if="filter.property" class="flex">
                                                <div class="flex-1">
                                                    <input v-model="filter.property" type="text" class="input mb-2" readonly>
                                                </div>
                                                <div class="ml-2">
                                                    <button @click="filter.property = null; propertiesSearch = '';" class="button" type="button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <input v-if="!filter.property" v-model="propertiesSearch" type="text" class="input mb-2" placeholder="Filter properties...">
                                            <transition-expand>
                                                <div v-if="!filter.property">
                                                    <select v-model="filter.property" class="input mb-2" size="5">
                                                        <option v-for="property in propertiesFiltered">{{ property }}</option>
                                                    </select>
                                                </div>
                                            </transition-expand>
                                        </div>

                                        <div class="group">
                                            <label>Condition</label>
                                            <select v-model="filter.condition" class="input mb-2">
                                                <option :value="null" disabled>Select condition...</option>
                                                <option>is</option>
                                                <option>is not</option>
                                                <option>contains</option>
                                                <option>does not contain</option>
                                                <option>is greater than</option>
                                                <option>is less than</option>
                                                <option>is empty</option>
                                                <option>is anything</option>
                                            </select>
                                        </div>

                                        <div class="group">
                                            <label>Value</label>
                                            <input v-model="filter.value" type="text" class="input mb-2" placeholder="Enter value...">
                                        </div>

                                        <div class="flex">
                                            <div class="flex-1 mr-1">
                                                <button @click="dismissNewFilter()" type="button" class="button w-full">
                                                    Close
                                                </button>
                                            </div>
                                            <div class="flex-1 ml-1">
                                                <button @click="addFilter()" type="button" class="button green w-full"
                                                    :disabled="!filter.property || !filter.condition">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition-expand>

                            <div v-if="!showNewFilter">
                                <button @click="showNewFilter = true" type="button" class="button green w-full">New Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="ml-6">
                <label>People</label>
            </div>
        </div>
    </div>
</template>

<script>
    var filter = require('lodash/filter')

    export default {
        props: [''],

        data() {
            return {
                propertiesSearch: '',
                properties: [],
                filters: [],
                showNewFilter: false,
                filter: {
                    property: null,
                    condition: null,
                    value: null
                }
            }
        },

        watch: {
            filter: {
                handler(newFilter, oldFilter) {
                    if (newFilter.property) {
                        //
                    }
                },
                deep: true
            }
        },

        computed: {
            propertiesFiltered() {
                return filter(this.properties, property => {
                    return String(property).toLowerCase().includes(this.propertiesSearch.toLowerCase())
                })
            }
        },

        methods: {
            addFilter() {
                this.filters.push({
                    property: this.filter.property,
                    condition: this.filter.condition,
                    value: this.filter.value
                })

                this.dismissNewFilter()
            },
            removeFilter(index) {
                this.$delete(this.filters, index)
            },
            dismissNewFilter() {
                this.propertiesSearch = ''
                this.showNewFilter = false
                this.filter = {
                    property: null,
                    condition: null,
                    value: null
                }
            },
            fetchProperties() {
                axios.get('/api/businesses/' + this.$root.business.id + '/properties')
                .then(response => {
                    this.properties = response.data.data.sort()
                })
            },
        },

        created() {
            this.fetchProperties()
        }
    }
</script>
