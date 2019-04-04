<template>
    <div class="flex">
        <div class="flex-1 flex flex-col border-r h-screen">
            <div class="overflow-y-scroll scrolling-touch flex">
                <div class="flex flex-col w-1/4 border-r">
                    <div class="border-b">
                        <input type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
                    </div>
                    <div class="p-2 overflow-y-scroll">
                        <div class="p-2">
                            <router-link :to="{ name: 'auto.new' }">
                                <button class="button green w-full">
                                    <i class="fas fa-fw fa-bolt"></i>
                                    New Auto
                                </button>
                            </router-link>
                        </div>
                        <div v-for="auto in autos" class="flex p-2 select-none" style="min-height: 110px;">
                            <div class="flex-1 flex flex-col border-4 rounded-lg overflow-hidden hover:border-green cursor-pointer">
                                <div class="flex-1 p-2">
                                    <h3 class="m-0">{{ auto }}</h3>
                                </div>
                                <div class="flex bg-grey-light p-2 pb-1">
                                    <div class="flex-1 text-green font-bold">
                                        <i class="fas fa-circle"></i> Active
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
                autos: [
                    '1 day after signup send a welcome email',
                    'At end of trial period send email encouraging to subscribe',
                    'Onboarding: Feature 1',
                    'Onboarding: Feature 2',
                    'Onboarding: Feature 3',
                ]
            }
        },

        computed: {
            //
        },

        methods: {
            //
        }
    }
</script>
