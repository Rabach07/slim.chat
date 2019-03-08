<template>
    <div class="flex">
        <navigation />

        <div class="flex-1">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navigation from './../components/Navigation'

    export default {
        components: { Navigation },

        mounted() {
            console.log('App.vue ready.')
        }
    }
</script>
