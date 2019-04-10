<template>
    <div id="navigation" class="pt-2 h-screen bg-green text-center text-white font-bold select-none border-r-4" style="border-color: rgba(0,0,0,0.1);">
        <div class="mb-4 p-4 border-b border-green-dark">
            <img src="/images/logo_white.png">
        </div>

        <router-link :to="{ name: 'profile' }">
            <div class="mb-8 cursor-pointer px-5">
                <img src="https://pbs.twimg.com/profile_images/1041629685363306497/f6F4dPMG_400x400.jpg"
                    class="rounded-full border-3 border-white">
                <span class="absolute bg-green text-sm rounded-full border-2 border-white"
                    style="top: 117px; left: 55px; padding: 1px 5px; min-width: 20px; min-height: 20px;">
                </span>
            </div>
        </router-link>

        <router-link :to="{ name: 'chat' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-comment mb-2"></i><br>
                Chat
                <span v-if="$root.conversations.length" class="absolute bg-red text-sm rounded-full border-2 border-white"
                    style="top: 205px; left: 52px; padding: 1px 5px">
                    {{ $root.conversations.length }}
                </span>
            </div>
        </router-link>
        <router-link :to="{ name: 'people' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-users mb-2"></i><br>
                People
            </div>
        </router-link>
        <router-link :to="{ name: 'auto' }">
            <div class="mb-8 cursor-pointer">
                <i class="fas fa-2x fa-bolt mb-2"></i><br>
                Auto
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
        @apply .no-underline .text-white;
        &:hover, &:active, &:focus {
            @apply .text-white;
        }
    }
</style>
