<template>
    <div class="flex">
        <navigation />

        <div class="w-1/5 border-r h-screen overflow-y-scroll select-none">
            <div class="border-b p-4 mt-4">
                <h1>Settings</h1>
            </div>
            <div class="py-1 px-4 w-full bg-grey-dark text-white font-semibold">
                <i class="fas fa-fw fa-window-restore"></i> Widget
            </div>
            <router-link :to="{ name: 'settings' }">
                <div class="p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <!-- <i class="fas fa-fw fa-palette"></i> --> Appearance
                </div>
            </router-link>
            <router-link :to="{ name: 'settings.behaviour' }">
                <div class="p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <!-- <i class="fas fa-fw fa-directions"></i> --> Behaviour
                </div>
            </router-link>
            <div class="py-1 px-4 w-full bg-grey-dark text-white font-semibold">
                <i class="fas fa-fw fa-briefcase"></i> Business
            </div>
            <router-link :to="{ name: 'settings.account' }">
                <div class="p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <!-- <i class="fas fa-fw fa-users"></i> --> Account
                </div>
            </router-link>
            <router-link :to="{ name: 'settings.team' }">
                <div class="p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <!-- <i class="fas fa-fw fa-sitemap"></i> --> Team
                </div>
            </router-link>
            <router-link :to="{ name: 'settings.billing' }">
                <div class="p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    <!-- <i class="fas fa-fw fa-credit-card"></i> --> Billing
                </div>
            </router-link>
        </div>

        <div class="flex-1">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                //
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
