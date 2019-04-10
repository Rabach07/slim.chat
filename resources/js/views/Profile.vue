<template>
    <div class="flex">
        <div class="flex-1 h-screen overflow-y-scroll">
            <div class="border-b p-4 mt-4">
                <h1 class="mb-0">Profile</h1>
            </div>

            <div class="p-4 xl:w-2/3">
                <form>
                    <div class="group">
                        <label>Name</label>
                        <input v-model="user.name" type="text" class="input">
                        <p>Your name will be shown publicly.</p>
                    </div>
                    <div class="group">
                        <label>Email</label>
                        <div class="flex">
                            <div class="flex-1 mr-2">
                                <input v-model="user.email" type="email" class="input">
                            </div>
                            <div>
                                <button v-if="user.email_verified_at" class="button green" disabled>
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </button>
                            </div>
                        </div>
                        <p>If you change your email you'll need to verify it again.</p>
                    </div>
                    <div class="group">
                        <div class="flex">
                            <div class="flex-1 mr-1">
                                <label>Password</label>
                                <input v-model="user.password" type="password" class="input">
                            </div>
                            <div class="flex-1 ml-1">
                                <label>Password Confirmation</label>
                                <input v-model="user.password_confirmation" type="password" class="input">
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <button @click.prevent="saveUser()" type="submit" class="button green">
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
                user: {},
            }
        },

        methods: {
            fetchUser() {
                axios.get('/api/user')
                .then(response => {
                    this.user = response.data.data
                })
            },
            saveUser() {
                axios.post('/api/user', this.user)
                .then(response => {
                    this.user = response.data.data
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            }
        },

        created() {
            this.fetchUser()
        }
    }
</script>
