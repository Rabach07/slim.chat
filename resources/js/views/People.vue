<template>
    <div class="flex">
        <div class="flex-1 flex flex-col border-r h-screen">
            <div class="flex-no-stretch">
                <div class="border-b p-4 mt-4">
                    <div class="flex items-baseline">
                        <h1 class="mb-0">People</h1>
                        <div class="mx-2 text-grey">showing {{ people.length }} of {{ peopleResponse.total }} people</div>
                    </div>
                </div>
                <div class="border-b">
                    <input v-model="peopleSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
                </div>
            </div>
            <div class="overflow-y-scroll scrolling-touch">
                <table class="people-table">
                    <thead class="header-fixed">
                        <tr>
                            <th v-for="fixedProperty in fixedProperties" class="">
                                <i class="fa fa-star text-grey"></i>
                                {{ fixedProperty | title }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="person in peopleFiltered" @click="selectedPerson = person" class="cursor-pointer" :class="selectedPerson == person && 'bg-grey-lightest'">
                            <td v-for="fixedProperty in fixedProperties">
                                {{ person.props[fixedProperty] }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="!peopleFiltered.length" class="p-4 text-center select-none text-grey">
                    No people found.
                </div>
            </div>
        </div>

        <div class="w-1/5">
            <properties v-if="selectedPerson" :visitor_id="selectedPerson.id" />
        </div>
    </div>
</template>

<script>
    var filter = require('lodash/filter')
    var capitalize = require('lodash/capitalize')

    import Properties from './../components/Properties'

    export default {
        components: { Properties },

        props: ['business_id'],

        data() {
            return {
                selectedPerson: null,
                peopleSearch: '',
                people: [],
                peopleResponse: {}
            }
        },

        computed: {
            peopleFiltered() {
                return filter(this.people, person => {
                    const keys = Object.keys(person.props)
                    for (const key of keys) {
                        return person.props[key].toLowerCase().includes(this.peopleSearch.toLowerCase())
                    }
                })
            },
            fixedProperties() {
                return this.$root.business.settings.properties_fixed.split(',')
            }
        },

        methods: {
            fetchPeople() {
                axios.get('/api/visitors', {
                    params: {
                        business_id: this.$root.business.id,
                        append: 'props',
                    }
                })
                .then(response => {
                    this.peopleResponse = response.data
                    this.people = response.data.data
                })
            }
        },

        created() {
            this.fetchPeople()
        }
    }
</script>

<style lang="scss" scoped>
    .people-table {
        @apply .w-full;

        thead {
            @apply .text-left .font-bold;

            tr {
                th {
                    @apply .p-4;
                    background: linear-gradient(to bottom, #ffffff calc(100% - 2px), #dae1e7 calc(100% - 2px));
                }
            }
        }
        tbody {
            tr {
                @apply .border-b;

                td {
                    @apply .p-4;
                }

                &:hover {
                    @apply .bg-grey-lightest;
                }
            }
        }
    }
</style>
