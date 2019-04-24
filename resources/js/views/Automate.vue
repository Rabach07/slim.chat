<template>
    <div class="flex h-screen overflow-hidden">
        <div class="w-1/5 border-r">
            <automations />
        </div>

        <div class="flex-1 h-screen flex flex-col border-r">
            <!-- <automation-detail v-if="selectedAutomation.id" :automation="selectedAutomation" /> -->
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Automations from './../components/Automations'
    import AutomationDetail from './../components/AutomationDetail'

    export default {
        components: { Automations, AutomationDetail },

        data() {
            return {
                selectedAutomation: {}
            }
        },

        created() {
            this.$bus.$on('automationSelected', automation => {
                this.selectedAutomation = automation
            })
        }
    }
</script>
