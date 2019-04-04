<template>
    <div>
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">New Auto</h1>
        </div>
        <div class="flex">
            <div class="w-1/3 p-4">
                <form>
                    <div class="group">
                        <div class="group">
                            <label>Match Filters</label>
                            <div class="flex">
                                <button class="input">All</button>
                                <button class="input">Any</button>
                            </div>
                        </div>

                        <label>Filters</label>
                        <div class="group">
                            <div v-for="filter in filters" class="input flex mb-1">
                                <div class="flex-1">
                                    If
                                    <span class="font-bold font-mono">{{ filter.property }}</span>
                                    <span class="font-bold font-mono">{{ filter.condition }}</span>
                                    <span class="font-bold font-mono">{{ filter.value }}</span>
                                </div>
                                <div class="text-grey">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>

                        <div v-if="showFilter" class="group input">
                            <div class="flex">
                                <div class="flex-1">
                                    <label>New Filter</label>
                                </div>
                                <div @click="showFilter = false">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>

                            <select class="input mb-1">
                                <option selected disabled>Choose property...</option>
                                <option>name</option>
                                <option>email</option>
                                <option>number_of_staff</option>
                            </select>
                            <select class="input mb-1">
                                <option selected disabled>Select condition...</option>
                                <option>is equal to</option>
                                <option>is not equal to</option>
                                <option>is greater than</option>
                                <option>is less than</option>
                                <option>is unknown</option>
                                <option>is anything</option>
                            </select>
                            <input type="text" class="input mb-1" placeholder="Enter value...">
                            <button @click="addFilter()" type="button" class="button green w-full">Add Filter</button>
                        </div>

                        <div v-if="!showFilter" class="group">
                            <button @click="showFilter = true" type="button" class="button green w-full">New Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-4">
                <label>Preview</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                filters: [{
                    property: 'email',
                    condition: 'is equal to',
                    value: 'Jack'
                }],
                showFilter: false,
                filter: {
                    property: null,
                    condition: null,
                    value: null
                }
            }
        },

        methods: {
            addFilter() {
                this.filters.push({
                    property: this.filter.property,
                    condition: this.filter.condition,
                    value: this.filter.value
                })

                this.filter = {
                    property: null,
                    condition: null,
                    value: null
                }

                this.showFilter = false
            }
        }
    }
</script>
