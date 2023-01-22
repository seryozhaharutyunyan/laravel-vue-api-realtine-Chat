<template>
    <header-component></header-component>
    <div class="col-10 m-auto mt-5">
        <h1>Countries</h1>
        <div v-if="showAdd" class="col-12 col-sm-6 m-auto mt-3">
            <h2>Add countries</h2>
            <input class="form-control m-3 mb-0  p-3" v-model.trim="name" placeholder="Name">
            <div class="text-start text-danger m-3">{{ error }}</div>
            <button class="btn btn-info m-2" @click="add()">Add</button>
            <button class="btn btn-info m-2" @click="showAdd=false; name=''; updateId=''">Close</button>
        </div>

        <div v-else class="col-12 mt-3 mb-3">
            <button @click="showAdd=true; name=''; updateId=''" class="btn btn-info">Add country</button>
        </div>
        <div class="d-flex mt-3 col-12 text-center justify-content-center ">
            <div class="col-sm-6 col-12 m-sm-auto">
                <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">UPDATE</th>
                        <th scope="col">DELETE</th>
                    </tr>
                    </thead>

                    <tbody>

                    <template v-for="(country, key) in countries.data" v-bind:key="key">
                        <tr :class="!isShow(country.id) ? '' : 'd-none'">
                            <td>{{ key + 1 }}</td>
                            <td>{{ country.name }}</td>
                            <td>
                                <a class="text-info btn" @click.prevent="setCountry(country)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a class="text-danger btn" @click.prevent="destroy(country.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <tr :class="isShow(country.id) ? '' : 'd-none'">
                            <td>{{ key + 1 }}</td>
                            <td>
                                <input type="text" v-model.trim="name" class="form-control">
                                <div class="text-danger text-start m-o ps-3">{{ error }}</div>
                            </td>
                            <td>
                                <a class="text-info btn" @click.prevent="update(country.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                        <path
                                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a class="text-danger btn" @click.prevent="destroy(country.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </template>

                    </tbody>
                </table>
                <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                    <pagination :pagination="countries" :callback="getResults" :size="'small'">

                    </pagination>
                </div>
            </div>
        </div>


    </div>

</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import api from "@/assets/axios/api";
import PaginationComponent from "@/components/PaginationComponent";

export default {
    name: "CountriesView",
    components: {
        HeaderComponent: HeaderComponent,
        Pagination: PaginationComponent,
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    data() {
        return {
            showAdd: false,
            countries: {},
            updateId: '',
            name: '',
            error: '',
        };
    },

    methods: {
        isShow(id) {
            return id === this.updateId;
        },

        setCountry(country) {
            this.name = country.name;
            this.updateId = country.id;
            this.showAdd = false;
        },

        add() {
            this.error = '';
            api.post(this.url + '/admin/countries', {
                name: this.name
            })
                .then(() => {
                    this.name = '';
                    this.query();
                })
                .catch(error => {
                    this.error = error.response.data.message;
                })
        },

        update(id) {

            api.post(this.url + '/admin/countries/' + id, {
                name: this.name
            })
                .then(() => {
                    this.name = '';
                    this.updateId = '';
                    this.showAdd = false;

                    this.query();
                })
                .catch(error => {
                    this.error = error.response.data.message;
                })

        },

        destroy(id) {
            api.delete(this.url + '/admin/countries/' + id)
                .then(() => {
                    this.query();
                })
                .catch(error => {
                    console.log(error);
                })
        },

        query() {
            api.get(this.url + '/admin/countries')
                .then(resolve => {
                    this.countries = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getResults(page = 1) {
            api.get(this.url + '/admin/countries?page=' + page)
                .then(r => {
                    this.countries = r.data;
                });
        },
    },

    created() {
        this.query();
    }
}
</script>

<style scoped>

</style>
