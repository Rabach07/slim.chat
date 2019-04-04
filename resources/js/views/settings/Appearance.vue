<template>
    <div class="h-screen flex flex-col overflow-y-scroll">
        <div class="flex-no-shrink border-b p-4 mt-4">
            <h1 class="mb-0">Appearance</h1>
        </div>

        <div class="flex overflow-y-scroll h-full p-4">
            <div class="flex-1">
                <form>
                    <div class="group flex-1">
                        <label>Logo</label>
                        <div class="flex">
                            <div class="flex-1 mr-2 border-4 rounded-full overflow-hidden" style="max-width: 100px; height: 100px;">
                                <img :src="settings.logo" onerror="this.src='/images/utility/image.png'" class="block w-full h-full">
                            </div>
                            <div class="flex-1">
                                <input v-if="!settings.logo" type="file" @change="onLogoChange" class="input">
                                <button v-if="settings.logo" @click="settings.logo = ''" class="button" type="button">
                                    <i class="fas fa-fw fa-times"></i> Remove image
                                </button>
                                <p>Must be square and at least 128x128 pixels.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-1 mr-2 group">
                            <label>Primary Color</label>
                            <div class="flex">
                                <input v-model="settings.colors.primary" type="color" class="input mr-2">
                                <input v-model="settings.colors.primary" type="text" class="input" maxlength="7">
                            </div>
                        </div>

                        <div class="flex-1 ml-2 group">
                            <label>Contrast Color</label>
                            <div class="flex">
                                <input v-model="settings.colors.contrast" type="color" class="input mr-2">
                                <input v-model="settings.colors.contrast" type="text" class="input" maxlength="7">
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button @click.prevent="save()" class="button green">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <div class="w-1/3 ml-6">
                <label>Preview</label>
                <div class="shadow-lg rounded-lg overflow-hidden pointer-events-none select-none" style="height: 400px;">
                    <chat-widget :app_id="12345" :visitor_uuid="'c60f3c4a-55d4-4086-85b5-4a91eb7271db'"
                        :settings="settings" :show="true" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ChatWidget from './../../widget/ChatWidget'

    export default {
        components: { ChatWidget },

        props: [''],

        data() {
            return {
                settings: {
                    colors: {
                        primary: '#38c172',
                        contrast: '#ffffff'
                    },
                    logo: '',
                }
            }
        },

        methods: {
            save() {
                //
            },
            onLogoChange(event) {
                var files = event.target.files || event.dataTransfer.files
                if (!files.length) return

                // var image = new Image()
                var reader = new FileReader()

                reader.onload = event => {
                    this.settings.logo = event.target.result
                }

                reader.readAsDataURL(files[0])
            },
        }
    }
</script>
