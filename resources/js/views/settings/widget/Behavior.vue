<template>
    <div class="h-screen flex flex-col overflow-y-scroll">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">Widget Behavior</h1>
        </div>

        <div class="flex overflow-y-scroll h-full p-4">
            <div class="xl:w-2/3">
                <form>
                    <div class="group">
                        <label>Timezone</label>
                        <p>
                            Your timezone is set to
                            <router-link :to="{ name: 'settings.account' }">
                                {{ $root.business.settings.timezone }}.
                            </router-link>
                        </p>
                    </div>

                    <div class="group">
                        <label>Available Hours</label>
                        <div>
                            <div v-for="(hour, index) in settings.hours" class="flex px-3 mb-1 py-2 border-4 rounded-lg">
                                <div class="flex-1 text-lg">
                                    <span class="font-bold mr-2">{{ hour[0] | title }}</span>
                                    <span>
                                        {{ hour[1] }} -
                                        {{ hour[2] }}
                                    </span>
                                </div>
                                <div class="text-grey">
                                    <i @click="removeHours(index)" class="fas fa-times cursor-pointer"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex border-4 rounded-lg p-2 bg-grey-lightest">
                            <div class="flex-1 mr-1">
                                <select v-model="newHour.day" class="input">
                                    <option :value="null" disabled>Select day...</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </div>
                            <div class="flex items-center mr-1">
                                <input v-model="newHour.startTime" type="time" class="input mr-1">
                                <div>to</div>
                                <input v-model="newHour.endTime" type="time" class="input ml-1">
                            </div>
                            <div>
                                <button @click="addHours()" :disabled="!newHour.day || !newHour.startTime || !newHour.endTime" type="button" class="button green">
                                    <i class="fas fa-plus"></i>
                                    Add Hours
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button @click="save()" class="button green" type="button">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                settings: {
                    hours: this.$root.business.settings.hours ? JSON.parse(this.$root.business.settings.hours) : []
                },
                newHour: {
                    day: null,
                    startTime: null,
                    endTime: null
                }
            }
        },

        computed: {
            //
        },

        methods: {
            addHours() {
                this.settings.hours.push([
                    this.newHour.day,
                    this.newHour.startTime,
                    this.newHour.endTime
                ])

                this.newHour = {
                    day: null,
                    startTime: null,
                    endTime: null
                }
            },
            removeHours(index) {
                this.$delete(this.settings.hours, index)
            },
            save() {
                axios.post('/api/businesses/' + this.$root.business.id + '/settings', {
                    settings: {
                        hours: JSON.stringify(this.settings.hours)
                    }
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            }
        },

        created() {
            //
        }
    }
</script>
