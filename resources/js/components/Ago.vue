<template>
    <span>{{ value }}</span>
</template>

<script>
    var distanceInWordsStrict = require('date-fns/distance_in_words_strict')

    export default {
        props: ['datetime'],

        data() {
            return {
                value: null,
                updater: null,
                frequency: 3
            }
        },

        watch: {
            datetime(newVal, oldVal) {
                this.stop()
                this.frequency = 3
                this.start()
                this.updateValue()
            },
        },

        methods: {
            start() {
                this.updater = setInterval(() => {
                    this.updateValue()
                }, 1000 * this.frequency)
            },
            stop() {
                if (this.updater) {
                    clearInterval(this.updater)
                    this.updater = null
                }
            },
            updateValue() {
                if (!this.datetime) {
                    this.value = ''
                } else {
                    let temp = distanceInWordsStrict(new Date(this.datetime), new Date).split(' ')

                    if (temp[1][0] == 's' && temp[0] < 10) {
                        this.value = 'just now'
                    } else if (temp[1][0] == 's') {
                        this.value = temp[0] + temp[1][0]
                    } else if (this.frequency != 60) {
                        this.stop()
                        this.frequency = 60
                        this.start()
                        this.value = temp[0] + temp[1][0]
                    } else {
                        this.value = temp[0] + temp[1][0]
                    }
                }
            }
        },

        mounted() {
            this.updateValue()
            this.start()
        },

        beforeDestroy() {
            this.stop()
        }
    }
</script>
