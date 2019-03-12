<template>
    <div class="w-1/5 h-screen">
        <div class="border-b">
            <input v-model="propertySearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search properties...">
        </div>
        <div class="overflow-y-scroll" style="height: calc(100vh - 65px);">
            <!-- <div class="p-4 border-b text-center select-none">
                <img src="https://www.gravatar.com/avatar/3eb3cc7bc4edce1206e5ca987df33fda?s=200"
                    class="w-24 h-24 rounded-full" /><br>

                <div class="font-bold mt-3 text-lg">Jack Cruden</div>
            </div>
            <div class="flex items-center p-4 border-b">
                <div class="flex-1 truncate">jackcruden@gmail.com</div>
                <div class="float-right select-none text-grey">
                    <i class="fas fa-at"></i>
                </div>
            </div>
            <div class="flex items-center p-4 border-b">
                <div class="flex-1 truncate">Taranaki, New Zealand</div>
                <div class="float-right select-none text-grey">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            <div class="flex items-center p-4 border-b">
                <div class="flex-1 truncate">9:05pm, 28th February</div>
                <div class="float-right select-none text-grey">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="flex items-center p-4 border-b">
                <div class="flex-1 truncate">Chrome 72, MacBook Pro</div>
                <div class="float-right select-none text-grey">
                    <i class="fas fa-laptop"></i>
                </div>
            </div>

            <div class="flex items-center border-b-2"></div> -->

            <div v-for="property in propertiesFiltered" class="items-center p-4 border-b">
                <div class="mb-2 text-xs text-grey font-semibold uppercase truncate select-none">
                    {{ property.name | title }}
                </div>
                <div class="truncate">
                    {{ property.value }}
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
            visitor_id(newId, oldId) {
                this.fetchProperties()
            }
        },

        computed: {
            propertiesFiltered() {
                return filter(this.properties, property => {
                    const combined = property.name.toLowerCase() + ' ' + property.value.toLowerCase()
                    return combined.includes(this.propertySearch)
                })
            }
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

        created() {
            this.fetchProperties()
        }
    }
</script>
