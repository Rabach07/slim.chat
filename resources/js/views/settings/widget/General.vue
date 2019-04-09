<template>
    <div class="h-screen flex flex-col overflow-y-scroll">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">Widget</h1>
        </div>

        <div class="xl:w-2/3 flex overflow-y-scroll h-full p-4">
            <div class="flex-1">
                <form>
                    <div class="group">
                        <label>Domain(s)</label>
                        <input type="text" class="input" placeholder="Enter domain(s)...">
                        <p>A comma separated list of domains you'd like to whitelist, e.g. "example.com, example2.com".</p>
                    </div>

                    <div class="actions">
                        <button class="button green">
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
