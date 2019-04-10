<template>
    <div class="flex flex-col h-screen">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">New Auto</h1>
        </div>

        <div class="overflow-y-scroll">
            <form class="flex p-4">
                <div class="w-3/5 mr-4">
                    <div class="group">
                        <label>Action</label>
                        <select class="input mb-1">
                            <option>Send email</option>
                            <option>Send chat message</option>
                        </select>
                        <textarea class="input" rows="5"></textarea>
                    </div>

                    <div class="actions">
                        <button class="button green">
                            Save Auto
                        </button>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="group">
                        <label>Match</label>
                        <select class="input">
                            <option>Match all filters</option>
                            <option>Match any filter(s)</option>
                        </select>
                    </div>

                    <label>Filters</label>
                    <div class="group">
                        <div v-for="(filter, index) in filters" class="input flex text-grey-darkest mb-1">
                            <div class="flex-1">
                                <span class="bg-grey-lighter px-1 rounded">{{ filter.property.name }}</span>
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
                                                <input v-model="filter.property.name" type="text" class="input mb-2" readonly>
                                            </div>
                                            <div class="ml-2">
                                                <button @click="
                                                    filter.property = null;
                                                    filter.condition = null;
                                                    filter.value = null;
                                                    propertiesSearch = '';" class="button" type="button">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <input v-if="!filter.property" v-model="propertiesSearch" type="text" class="input mb-2" placeholder="Filter properties...">
                                        <transition-expand>
                                            <div v-if="!filter.property">
                                                <select v-model="filter.property" class="input mb-2" size="5">
                                                    <option v-for="property in propertiesFiltered" :value="property">
                                                        {{ property.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </transition-expand>
                                    </div>

                                    <div class="group">
                                        <label>Condition</label>
                                        <input v-if="!filter.property" type="text" class="input" placeholder="Select condition..." disabled>
                                        <select v-else v-model="filter.condition" :disabled="!filter.property" class="input mb-2">
                                            <option :value="null" disabled>Select condition...</option>
                                            <option v-for="condition in allowedConditions[filter.property.type]">
                                                {{ condition }}
                                            </option>
                                        </select>
                                    </div>

                                    <transition-expand>
                                        <div v-if="!['is anything', 'is empty'].includes(filter.condition)" class="group">
                                            <label>Value</label>
                                            <div v-if="!filter.property || !filter.condition">
                                                <input v-model="filter.value" type="text" class="input" placeholder="Enter value..." disabled>
                                            </div>
                                            <div v-else-if="filter.property.type == 'boolean'">
                                                <select v-model="filter.value" class="input">
                                                    <option :value="null" disabled>Select value...</option>
                                                    <option :value="true">True</option>
                                                    <option :value="false">False</option>
                                                </select>
                                            </div>
                                            <div v-else>
                                                <input v-model="filter.value" :type="filter.property.type" class="input" placeholder="Enter value...">
                                            </div>
                                        </div>
                                    </transition-expand>

                                    <div class="flex">
                                        <div class="flex-1 mr-1">
                                            <button @click="dismissNewFilter()" type="button" class="button w-full">
                                                <i class="fas fa-times"></i> Close
                                            </button>
                                        </div>
                                        <div class="flex-1 ml-1">
                                            <button @click="addFilter()" type="button" class="button green w-full"
                                                :disabled="!filter.property || !filter.condition">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition-expand>

                        <div v-if="!showNewFilter">
                            <button @click="showNewFilter = true" type="button" class="button green w-full">
                                <i class="fas fa-filter"></i> New Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
                allowedConditions: {
                    text: ['is', 'is not', 'contains', 'does not contain', 'is empty', 'is anything'],
                    number: ['is', 'is not', 'is greater than', 'is less than', 'is empty', 'is anything'],
                    boolean: ['is', 'is not', 'is empty', 'is anything'],
                    date: ['is', 'is not', 'is greater than', 'is less than', 'is empty', 'is anything'],
                },
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
                    return String(property.name).toLowerCase().includes(this.propertiesSearch.toLowerCase())
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
