<template>
    <div class="flex">
        <navigation />

        <div class="w-1/5 border-r h-screen">
            <div class="border-b p-4 mt-4">
                <h1 class="mb-0">People</h1>
            </div>
            <div class="border-b">
                <input v-model="peopleSearch" type="text" class="focus:outline-none w-full p-4 leading-loose" placeholder="Search...">
            </div>
            <div class="overflow-y-scroll scrolling-touch" style="height: calc(100vh - 170px);">
                <div v-for="person in peopleFiltered" class="flex items-center p-4 border-b hover:bg-grey-lighter cursor-pointer">
                    {{ person.name }}
                </div>
                <div v-if="!peopleFiltered.length" class="p-4 text-center select-none text-grey">
                    No people found.
                </div>
            </div>
        </div>

        <div class="flex-1 h-screen overflow-y-scroll scrolling-touch">
            <table class="people-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Website</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="person in peopleFiltered">
                        <td>{{ person.id }}</td>
                        <td>{{ person.name }}</td>
                        <td>{{ person.username }}</td>
                        <td>{{ person.email }}</td>
                        <td>{{ person.phone }}</td>
                        <td>{{ person.website }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                peopleSearch: '',
                people: [],
            }
        },

        computed: {
            peopleFiltered() {
                return this.people
            }
        },

        methods: {
            fetchPeople() {
                axios.get('https://jsonplaceholder.typicode.com/users')
                .then(response => {
                    this.people = response.data
                })
            }
        },

        created() {
            this.fetchPeople()
        }
    }
</script>

<style lang="scss" scoped>
    .people-table {
        @apply .w-full;

        thead {
            @apply .text-left .font-bold;

            tr {
                @apply .border-b-2;

                th {
                    @apply .p-3;
                }
            }
        }
        tbody {
            tr {
                @apply .border-b;

                td {
                    @apply .p-3;
                }
            }
        }
    }
</style>
