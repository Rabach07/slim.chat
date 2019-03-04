<template>
    <div class="w-24 py-6 h-screen bg-green text-center text-white font-bold select-none border-r-2 border-green-dark">
        <router-link :to="{ name: 'app' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-comment mb-2"></i><br>
                Chat
            </div>
        </router-link>
        <router-link :to="{ name: 'profile' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-users mb-2"></i><br>
                People
            </div>
        </router-link>
        <router-link :to="{ name: 'profile' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-user-circle mb-2"></i><br>
                Profile
            </div>
        </router-link>
        <router-link :to="{ name: 'settings' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-cog mb-2"></i><br>
                Settings
            </div>
        </router-link>
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

<style lang="scss" scoped>
    a {
        @apply .text-white;
        &:hover, &:active, &:focus {
            @apply .text-white;
        }
    }
</style>
