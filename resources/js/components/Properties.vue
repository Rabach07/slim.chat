<template>
    <div class="flex flex-col h-screen">
        <div class="flex-no-stretch border-b">
            <input v-model="propertySearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search properties...">
        </div>
        <div class="overflow-y-scroll">
            <!-- <div class="p-4 border-b text-center select-none">
                <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200"
                    class="w-24 h-24 rounded-full" /><br>

                <div class="font-bold mt-3 text-lg">Jack Cruden</div>
            </div> -->

            <div v-for="property in propertiesFiltered" class="items-center p-4 border-b">
                <div class="mb-2 text-xs text-grey font-semibold uppercase truncate select-none">
                    <span v-if="property.fixed" class="text-orange">
                        <i v-if="property.fixed" class="fa fa-star"></i>
                        {{ property.name | title }}
                    </span>
                    <span v-if="! property.fixed">
                        <i v-if="property.fixed" class="fa fa-fw fa-star"></i>
                        {{ property.name | title }}
                    </span>
                </div>
                <div class="truncate" :class="property.value.length ? '' : 'select-none'">
                    {{ property.value.length ? property.value : '&empty;' }}
                </div>
            </div>

            <div v-if="!propertiesFiltered.length" class="p-4 text-center select-none text-grey">
                No properties found.
            </div>
        </div>
    </div>
</template>

<script>
    var sortBy = require('lodash/sortBy')
    var filter = require('lodash/filter')

    export default {
        props: ['visitor_id'],

        data() {
            return {
                propertySearch: '',
                properties: [],
            }
        },

        watch: {
            visitor_id: {
                handler(newId, oldId) {
                    this.fetchProperties()

                    if (oldId) {
                        Echo.leave('businesses.'+this.$root.business.id+'.visitors.'+oldId+'.properties')
                    }

                    Echo.channel('businesses.'+this.$root.business.id+'.visitors.'+newId+'.properties')
                    .listen('PropertiesUpdated', event => {
                        this.fetchProperties()
                    })
                },
                immediate: true
            }
        },

        computed: {
            propertiesFiltered() {
                let properties = []
                let fixedProperties = this.$root.business.settings.fixed_properties.split(',')

                // Determine fixed properties
                properties = this.properties.map(property => {
                    return {
                        fixed: fixedProperties.includes(property.name),
                        name: property.name,
                        value: property.value
                    }
                })

                // Filter by search
                properties = filter(properties, property => {
                    const combined = property.name.toLowerCase() + ' ' + property.value.toLowerCase()
                    return combined.includes(this.propertySearch)
                })

                // Sort
                return properties.sort((propertyA, propertyB) => {
                    if (propertyA.fixed && !propertyB.fixed) {
                        return -1
                    } else if (!propertyA.fixed && propertyB.fixed) {
                        return 1
                    } else if (propertyA.fixed && propertyB.fixed) {
                        return fixedProperties.indexOf(propertyA.name) - fixedProperties.indexOf(propertyB.name)
                    } else if (propertyA.fixed == propertyB.fixed) {
                        return propertyA.name.localeCompare(propertyB.name)
                    }
                })
            },
        },

        methods: {
            fetchProperties() {
                axios.get('/api/properties/', {
                    params: {
                        visitor_id: this.visitor_id,
                        limit: 100,
                    }
                })
                .then(response => {
                    this.properties = response.data.data
                })
            },
        },

        beforeDestroyed() {
            Echo.leave('businesses.'+this.$root.business.id+'.visitors.'+this.visitor_id+'.properties')
        },
    }
</script>
