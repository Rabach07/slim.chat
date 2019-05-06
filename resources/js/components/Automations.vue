<template>
    <div class="flex-col h-screen">
        <div class="border-b p-4 mt-4">
            <div class="flex items-baseline">
                <h1 class="mb-0">Automations</h1>
            </div>
        </div>
        <div class="flex-no-stretch border-b">
            <input v-model="automationSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
        </div>
        <div class="p-2 overflow-y-scroll" style="height: calc(100vh - 65px - 53px);">
            <router-link :to="{ name: 'automate.new' }">
                <button class="button green w-full mb-2">
                    <i class="fas fa-fw fa-bolt"></i>
                    New Automation
                </button>
            </router-link>

            <router-link v-for="automation in automationsFiltered"
                :to="{ name: 'automate.show', params: { automationId: automation.id }}"
                :key="'automation'+automation.id"
                class="no-underline"
            >
                <automation
                    :automation="automation"
                    :class="selectedautomation.id == automation.id ? 'bg-grey-lighter' : ''"
                />
            </router-link>

            <div v-if="!automationsFiltered.length" class="p-4 text-center select-none text-grey">
                No automations to show.
            </div>
        </div>
    </div>
</template>

<script>
    var sortBy = require('lodash/sortBy')
    var filter = require('lodash/filter')

    import Automation from './../components/Automation'

    export default {
        components: { Automation },

        data() {
            return {
                automationSearch: '',
                selectedautomation: {},
                automations: [],
            }
        },

        watch: {
            filters: {
                handler(newVal, oldVal) {
                    this.fetchAutomations()
                },
                deep: true
            }
        },

        computed: {
            automationsFiltered() {
                return filter(this.automations, automation => {
                    return automation.name.toLowerCase().includes(this.automationSearch.toLowerCase())
                })
            }
        },

        methods: {
            fetchAutomations() {
                axios.get('/api/automations', {
                    params: {
                        business_id: this.$root.business.id
                    }
                })
                .then(response => {
                    this.automations = response.data.data
                })
            }
        },

        created() {
            this.fetchAutomations()

            this.$bus.$on('automationSelected', automation => {
                this.selectedautomation = automation
            })

            Echo.channel('businesses.' + this.$root.business.id + '.automations')
            .listen('automationUpdated', event => {
                this.fetchAutomations()
            })
        },

        beforeDestroyed() {
            Echo.leave('businesses.' + this.$root.business.id + '.automations')
        },
    }
</script>
