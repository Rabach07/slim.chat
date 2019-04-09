<template>
    <div class="h-screen flex flex-col overflow-y-scroll">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">Widget Appearance</h1>
        </div>

        <div class="flex overflow-y-scroll h-full p-4">
            <div class="flex-1">
                <form>
                    <div class="group flex-1">
                        <label>Logo</label>
                        <div class="flex">
                            <div class="flex-1 mr-2 border-4 rounded-lg overflow-hidden bg-grey-lighter"
                                style="max-width: 100px; height: 100px;"
                            >
                                <img :src="widget.settings.logo" onerror="this.src='/images/utility/image.png'" class="block w-full h-full">
                            </div>
                            <div class="flex-1">
                                <input v-if="!widget.settings.logo" type="file" @change="onLogoChange" class="input">
                                <button v-if="widget.settings.logo" @click="widget.settings.logo = ''" class="button" type="button">
                                    <i class="fas fa-fw fa-times"></i> Remove image
                                </button>
                                <p>Must be a square PNG at least 128x128 in size.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-1 mr-2 group">
                            <label>Primary Color</label>
                            <div class="flex">
                                <input v-model="widget.settings.color_primary" type="color" class="input mr-2">
                                <input v-model="widget.settings.color_primary" type="text" class="input" maxlength="7">
                            </div>
                        </div>

                        <div class="flex-1 ml-2 group">
                            <label>Contrast Color</label>
                            <div class="flex">
                                <input v-model="widget.settings.color_contrast" type="color" class="input mr-2">
                                <input v-model="widget.settings.color_contrast" type="text" class="input" maxlength="7">
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button @click.prevent="saveAppearance()" class="button green">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <div class="w-1/3 ml-6">
                <label>Preview</label>
                <div class="shadow-lg rounded-lg overflow-hidden pointer-events-none select-none" style="height: 400px;">
                    <chat-widget :app_id="$root.business.app_id" :visitor_uuid="'c60f3c4a-55d4-4086-85b5-4a91eb7271db'"
                        :business="widget.business" :settings="widget.settings" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ChatWidget from './../../../widget/ChatWidget'

    export default {
        components: { ChatWidget },

        props: [''],

        data() {
            return {
                widget: {
                    business: {
                        name: this.$root.business.name
                    },
                    settings: {
                        logo: '/storage/business_logos/' + this.$root.business.app_id + '.png',
                        color_primary: this.$root.business.settings.color_primary,
                        color_contrast: this.$root.business.settings.color_contrast
                    }
                }
            }
        },

        methods: {
            saveAppearance() {
                axios.post('/api/businesses/' + this.$root.business.id + '/settings', {
                    settings: {
                        color_primary: this.widget.settings.color_primary,
                        color_contrast: this.widget.settings.color_contrast
                    }
                })
                .then(response => {
                    this.$toasted.global.saved()
                })
            },
            onLogoChange(event) {
                var files = event.target.files || event.dataTransfer.files
                if (!files.length) return

                console.log('Uploading logo.')
                this.$toasted.show('Uploading logo...', {
                    type: 'info',
                    icon: 'fa-sync-alt'
                })

                let formData = new FormData()
                formData.append('logo', files[0])
                axios.post('/api/businesses/' + this.$root.business.id + '/settings/logo', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                })
                .then(response => {
                    this.$toasted.show('Logo uploaded successfully!', {
                        type: 'success',
                        icon: 'fa-check-circle'
                    })
                })
                .catch(erorr => {
                    this.$toasted.show('Logo upload failed', {
                        type: 'error',
                        icon: 'fa-exclamation-triangle'
                    })
                })

                var reader = new FileReader()

                reader.onload = event => {
                    this.widget.settings.logo = event.target.result
                }

                reader.readAsDataURL(files[0])
            },
        }
    }
</script>
