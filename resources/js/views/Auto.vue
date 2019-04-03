<template>
    <div class="flex">
        <div class="flex-1 flex flex-col border-r h-screen">
            <div class="flex-no-stretch border-b p-4 mt-4">
                <div class="flex items-bottom">
                    <h1 class="mb-0">Auto</h1>
                    <div class="flex-1 text-right">
                        <button class="button green">
                            <i class="fas fa-fw fa-bolt"></i> New Auto
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-y-scroll scrolling-touch">
                <div class="flex flex-wrap p-2">
                    <div v-for="auto in autos" class="w-1/4 flex p-2 select-none" style="min-height: 110px;">
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
