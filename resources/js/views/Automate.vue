<template>
    <div class="flex">
        <div class="flex-1 flex flex-col h-screen">
            <div class="overflow-y-scroll h-full flex">
                <div class="w-1/4 flex flex-col border-r">
                    <div class="border-b">
                        <input type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
                    </div>
                    <div class="p-2 overflow-y-scroll">
                        <div class="p-2">
                            <router-link :to="{ name: 'automate.new' }">
                                <button class="button green w-full">
                                    <i class="fas fa-fw fa-bolt"></i>
                                    New Automation
                                </button>
                            </router-link>
                        </div>
                        <div v-for="automation in automations" class="flex p-2 select-none" style="min-height: 110px;">
                            <div class="flex-1 flex flex-col border-4 rounded-lg overflow-hidden hover:border-green cursor-pointer">
                                <div class="flex-1 p-2">
                                    <h3 class="m-0">{{ automation.name }}</h3>
                                </div>
                                <div class="flex bg-grey-light p-2 pb-1">
                                    <div v-if="automation.active" class="flex-1 text-green font-bold">
                                        <i class="fas fa-circle"></i> Active
                                    </div>
                                    <div v-if="!automation.active" class="flex-1 font-bold">
                                        <i class="fas fa-circle"></i> Inactive
                                    </div>

                                    <div class="flex">
                                        <div class="ml-4">
                                            <i class="fas fa-hand-pointer"></i> 43
                                        </div>
                                        <div class="ml-4">
                                            <i class="fas fa-eye"></i> 24
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-scroll">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                automations: []
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
        }
    }
</script>
