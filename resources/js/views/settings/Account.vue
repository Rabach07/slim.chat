<template>
    <div class="h-screen overflow-y-scroll">
        <div class="border-b p-4 mt-4">
            <h1 class="mb-0">Account</h1>
        </div>

        <div class="p-4 xl:w-2/3">
            <form>
                <div class="group">
                    <label>Name</label>
                    <input v-model="business.name" type="text" name="name" class="input">
                    <p>Your business name will be shown publicly.</p>
                </div>
                <div class="actions">
                    <button @click.prevent="saveBusiness()" type="submit" class="button green">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                business: {},
            }
        },

        computed: {
            //
        },

        methods: {
            fetchBusiness() {
                axios.get('/api/businesses/' + this.$business.id)
                .then(response => {
                    this.business = response.data.data
                })
            },
            saveBusiness() {
                axios.post('/api/business', {
                    name: this.business.name
                })
                .then(response => {
                    this.business = response.data
                })
            }
        },

        created() {
            this.fetchBusiness()
        }
    }
</script>
