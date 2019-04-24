<template>
    <div class="h-screen overflow-y-scroll">
        <div class="header">
            <h1>Import</h1>
        </div>

        <div>
            <!-- Stages -->
            <div class="flex items-center pt-2 px-2 -mb-4 select-none">
                <div @click="setStage(1)" class="flex-1 m-2 alert" :class="stage.current >= 1 ? 'success cursor-pointer' : ''">
                    <h3 class="my-0">1. Export</h3>
                </div>
                <div>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div @click="setStage(2)" class="flex-1 m-2 alert" :class="stage.current >= 2 ? 'success cursor-pointer' : ''">
                    <h3 class="my-0">2. Upload</h3>
                </div>
                <div>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div @click="setStage(3)" class="flex-1 m-2 alert" :class="stage.current >= 3 ? 'success cursor-pointer' : ''">
                    <h3 class="my-0">3. Classify</h3>
                </div>
                <div>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div @click="setStage(4)" class="flex-1 m-2 alert" :class="stage.current >= 4 ? 'success cursor-pointer' : ''">
                    <h3 class="my-0">4. Process</h3>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                <form v-if="stage.current == 1">
                    <div class="alert info">
                        You'll first need to export your data as a CSV file from your current provider.
                    </div>

                    <div class="group">
                        <label>Export Instructions </label>
                        <a href="https://www.intercom.com/help/faqs-and-troubleshooting/your-users-and-leads-data-in-intercom/can-i-export-user-or-company-data-as-a-csv" target="_blank">Intercom</a>,
                        <a href="https://gethelp.drift.com/hc/en-us/articles/360019625593-Exporting-your-Contacts" target="_blank">Drift</a>.
                    </div>

                    <div class="actions">
                        <button @click="setMaxStage(2); setStage(2);" class="button green" type="button">
                            Next <i class="fas fa-fw fa-chevron-right"></i>
                        </button>
                    </div>
                </form>

                <form v-if="stage.current == 2">
                    <div class="alert info">
                        Select the exported CSV file below to import it to Slim Chat.
                    </div>

                    <div class="group">
                        <label>Choose CSV File</label>
                        <input @change="fileChanged" type="file" class="input">
                        <p>{{ upload.status }}</p>
                    </div>

                    <div class="actions">
                        <button @click="setStage(stage.current - 1)" class="button" type="button">
                            <i class="fas fa-fw fa-chevron-left"></i> Back
                        </button>
                        <button @click="setMaxStage(3); setStage(3);" class="button green" type="button" :disabled="!upload.complete">
                            Next <i class="fas fa-fw fa-chevron-right"></i>
                        </button>
                    </div>
                </form>

                <form v-if="stage.current == 3">
                    <div class="alert info">
                        Select and classify the properties to be imported.
                    </div>

                    <div class="group border-4 rounded-lg">
                        <table class="table">
                            <thead class="header-fixed">
                                <tr>
                                    <th>Original</th>
                                    <th>Formatted</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(property, index) in properties">
                                    <td>{{ property.original }}</td>
                                    <td>
                                        <input type="text" class="input" v-model="properties[index].parsed">
                                    </td>
                                    <td>
                                        <select v-model="properties[index].type" class="input">
                                            <option>Text</option>
                                            <option>Number</option>
                                            <option>Boolean</option>
                                            <option>Date</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="actions">
                        <button @click="setStage(stage.current - 1)" class="button" type="button">
                            <i class="fas fa-fw fa-chevron-left"></i> Back
                        </button>
                        <button @click="setMaxStage(4); setStage(4);" class="button green" type="button">
                            Next <i class="fas fa-fw fa-chevron-right"></i>
                        </button>
                    </div>
                </form>

                <form v-if="stage.current == 4">
                    <div class="alert info">
                        <strong><i class="fas fa-fw fa-spin fa-circle-notch"></i> Processing</strong>
                        The imported data is being processed and will be ready shortly.
                    </div>

                    <div class="actions">
                        <button class="button green" type="button">
                            New Import
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
                stage: {
                    current: 1,
                    max: 1
                },
                upload: {
                    status: 'Waiting for file.',
                    complete: false
                },
                properties: []
            }
        },

        methods: {
            fileChanged(event) {
                var files = event.target.files || event.dataTransfer.files
                if (!files.length) return

                let formData = new FormData()
                formData.append('file', files[0])
                formData.append('business_id', this.$root.business.id)
                this.upload.status = 'Uploading...'
                this.upload.complete = false
                axios.post('/api/import', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                })
                .then(response => {
                    this.properties = response.data.data.properties
                    this.upload.complete = true

                    this.upload.status = 'File uploaded! ' + response.data.data.properties.length + ' properties and ' + response.data.data.number_of_records + ' records found.'
                    this.$toasted.show('File uploaded successfully!', {
                        type: 'success',
                        icon: 'fa-check-circle'
                    })
                })
                .catch(erorr => {
                    this.upload.complete = false

                    this.upload.status = 'Upload failed. Please try again.'
                    this.$toasted.show('Upload failed', {
                        type: 'error',
                        icon: 'fa-exclamation-triangle'
                    })
                })
            },
            setStage(stage) {
                if (this.stage.max >= stage) {
                    this.stage.current = stage
                }
            },
            setMaxStage(maxStage) {
                this.stage.max = maxStage
            }
        }
    }
</script>
