<template>
    <div class="flex flex-col h-screen">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">{{ automation.name || 'automation' }}</h1>
        </div>

        <div class="overflow-y-scroll">
            <form class="p-4">
                <div class="group">
                    <label>Message</label>
                    <new-message v-model="automation.message" :editable="editing" />
                </div>
            </form>

            <form class="flex p-4">
                <div class="w-1/2 mr-4">
                    <h1>Filters</h1>

                    <div class="group">
                        <label>Match</label>
                        <select v-model="automation.logic" class="input" :disabled="!editing">
                            <option value="and">Match all filters</option>
                            <option value="or">Match any filter(s)</option>
                        </select>
                    </div>

                    <label>Filters</label>
                    <div class="group">
                        <div v-for="(filter, index) in automation.filters" class="input flex text-grey-darkest mb-1">
                            <div class="flex-1">
                                <span class="bg-grey-lighter px-1 rounded">{{ filter.property.name }}</span>
                                <span>{{ filter.condition }}</span>
                                <span v-if="filter.value" class="bg-grey-lighter px-1 rounded">{{ filter.value }}</span>
                            </div>
                            <div v-if="editing" @click="removeFilter(index)" class="ml-1 text-grey cursor-pointer">
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

                        <div v-if="editing && !showNewFilter" class="actions">
                            <button @click="showNewFilter = true" type="button" class="button green">
                                <i class="fas fa-fw fa-filter"></i> New Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="group">
                        <label>Audience</label>
                        <div>
                            <img src="https://pbs.twimg.com/profile_images/1041629685363306497/f6F4dPMG_400x400.jpg" class="rounded-full w-12 h-12">
                            <img src="https://pbs.twimg.com/profile_images/1041629685363306497/f6F4dPMG_400x400.jpg" class="rounded-full w-12 h-12">
                            <img src="https://pbs.twimg.com/profile_images/1041629685363306497/f6F4dPMG_400x400.jpg" class="rounded-full w-12 h-12">
                        </div>
                    </div>
                </div>
            </form>

            <form class="flex p-4">
                <div class="w-1/2 mr-4">
                    <div class="group">
                        <label>Schedule</label>
                        <div class="flex">
                            <div class="flex-1">
                                <select class="input" :disabled="!editing">
                                    <option>Monday</option>
                                    <option>Tuesday</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="button">
                            Save Draft
                        </button>
                        <button @click="saveAutomation()" type="button" class="button green">
                            <i class="fas fa-fw fa-play-circle"></i>
                            Start Automation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    var filter = require('lodash/filter')
    import NewMessage from './auto/NewMessage'

    export default {
        components: { NewMessage },

        props: ['automationId'],

        data() {
            return {
                editing: false,
                propertiesSearch: '',
                properties: [],
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
                },
                automation: {
                    name: '',
                    active: false,
                    message: '<p>yowsa</p>',
                    logic: 'and',
                    filters: [],
                },
            }
        },

        watch: {
            automationId: {
                handler(automationId) {
                    if (automationId != 'new') {
                        this.fetchAutomation()
                    }
                },
                immediate: true
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
            fetchAutomation() {
                axios.get('/api/automations/' + this.automationId, {
                    params: {
                        business_id: this.$root.business.id
                    }
                })
                .then(response => {
                    this.automation = response.data.data
                })
            },
            saveAutomation() {
                axios.post('/api/automations', {
                    business_id: this.$root.business.id,
                    name: this.automation.name,
                    active: false,
                    message: this.automation.message,
                    logic: this.automation.logic,
                    filters: this.automation.filters
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            },
            addFilter() {
                this.automation.filters.push({
                    property: this.filter.property,
                    condition: this.filter.condition,
                    value: this.filter.value
                })

                this.dismissNewFilter()
            },
            removeFilter(index) {
                this.$delete(this.automation.filters, index)
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
