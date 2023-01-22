<template>
    <header-component></header-component>
    <div class="col-10 m-auto mt-5">
        <h1>Chats</h1>
        <div v-if="showAdd" class="col-12 col-sm-6 m-auto mt-3">
            <h2>Add chat</h2>
            <input class="form-control m-3 mb-0  p-3" v-model.trim="name" placeholder="Name">
            <div class="text-start text-danger m-3">{{ error.name[0] }}</div>
            <select class="form-control m-3 mb-0 p-3" v-model="country_id_form" @change="getEdgesForm()">
                <option value="" disabled>Country</option>
                <option v-for="(county, key) in countriesForm" :value="county.id" :key="key">
                    {{ county.name }}
                </option>
            </select>
            <div class="text-start text-danger m-3">{{ error.country_id[0] }}</div>
            <select v-if="edgesForm.length" class="form-control m-3 mb-0 p-3" v-model="edge_id_form">
                <option value="" disabled>Edges</option>
                <option v-for="(edge, key) in edgesForm" :value="edge.id" :key="key">
                    {{ edge.name }}
                </option>
            </select>
            <div v-if="edgesForm.length" class="text-start text-danger m-3">{{ error.edge_id[0] }}</div>
            <button class="btn btn-info m-2" @click="add()">Add</button>
            <button class="btn btn-info m-2" @click="show()">Close</button>
        </div>

        <div v-else class="col-12 mt-3 mb-3">
            <button @click="show()" class="btn btn-info">Add
                edge
            </button>
        </div>

        <div class="col-12 col-sm-5 m-auto mt-3 mb-3">
            <select class="form-control m-3 mb-0 p-3" v-model="country_id" @change="getEdgesBasic()">
                <option value="" disabled>Country</option>
                <option v-for="(county, key) in countries" :value="county.id" :key="key">
                    {{ county.name }}
                </option>
            </select>
        </div>
        <div v-if="edges.length" class="col-12 col-sm-5 m-auto mt-3 mb-3">
            <select class="form-control m-3 mb-0 p-3" v-model="edge_id" @change="getChats()">
                <option value="" disabled>Edge</option>
                <option v-for="(edge, key) in edges" :value="edge.id" :key="key">
                    {{ edge.name }}
                </option>
            </select>
        </div>

        <div class="d-flex mt-3 col-12 text-center justify-content-center ">
            <div class="col-sm-6 col-12 m-sm-auto">
                <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">EDGE</th>
                        <th scope="col">COUNTRY</th>
                        <th scope="col">UPDATE</th>
                        <th scope="col">DELETE</th>
                    </tr>
                    </thead>

                    <tbody>

                    <template v-for="(chat, key) in chats.data" v-bind:key="key">
                        <tr :class="!isShow(chat.id) ? '' : 'd-none'">
                            <td>{{ key + 1 }}</td>
                            <td>{{ chat.name }}</td>
                            <td>{{ chat.edge.name }}</td>
                            <td>{{ chat.edge.country.name }}</td>
                            <td>
                                <a class="text-info btn" @click.prevent="setCountry(chat)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a class="text-danger btn" @click.prevent="destroy(chat.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <tr :class="isShow(chat.id) ? '' : 'd-none'">
                            <td>{{ key + 1 }}</td>
                            <td>
                                <input type="text" v-model.trim="name" class="form-control">
                                <div class="text-danger text-start m-0 ps-3">{{ error.name[0] }}</div>
                            </td>
                            <td>{{ chat.edge.name }}</td>
                            <td>{{ chat.edge.country.name }}</td>
                            <td>
                                <a class="text-info btn" @click.prevent="update(chat.id)">
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
                                <a class="text-danger btn" @click.prevent="destroy(chat.id)">
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
                    <pagination :pagination="chats" :callback="getResults" :size="'small'">

                    </pagination>
                </div>
            </div>
        </div>


    </div>

</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import PaginationComponent from "@/components/PaginationComponent";
import api from "@/assets/axios/api";

export default {
    name: "ChatsView",
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
            chats: {},
            edges: {},
            edgesForm: {},
            countries: {},
            countriesForm: {},
            updateId: '',
            name: '',
            country_id: '',
            country_id_form: '',
            edge_id: '',
            edge_id_form: '',
            error: {
                name: [''],
                country_id: [''],
                edge_id: ['']
            },
        };
    },

    methods: {
        isShow(id) {
            return id === this.updateId;
        },

        show() {
            this.error = {
                name: [''],
                country_id: [''],
                edge_id: ['']
            };
            this.countriesForm = this.countries
            this.showAdd = !this.showAdd;
            this.name = '';
            this.country_id_form = '';
            this.edge_id_form = '';
            this.updateId = '';

        },

        setCountry(chat) {
            this.name = chat.name;
            this.updateId=chat.id;
            this.showAdd = false;
        },

        add() {
            this.error = {
                name: [''],
                country_id: [''],
                edge_id: ['']
            };
            api.post(this.url + '/admin/chats', {
                name: this.name,
                country_id: this.country_id_form,
                edge_id: this.edge_id_form
            })
                .then(() => {
                    this.name = '';
                    this.country_id_form = '';
                    this.edge_id_form = '';
                    this.updateId = '';
                    this.edgesForm={};
                    this.getChats()
                })
                .catch(error => {
                    console.log(error)
                    this.error = Object.assign(this.error, error.response.data.errors);
                })
        },

        update(id) {
            this.error = {
                name: [''],
                country_id: [''],
                edge_id: ['']
            };
            api.post(this.url + '/admin/chats/' + id, {
                name: this.name,
            })
                .then(() => {
                    this.name = '';
                    this.showAdd = false;
                    this.updateId='';
                    this.getChats();
                })
                .catch(error => {
                    this.error = Object.assign(this.error, error.response.data.errors);
                })
        },

        destroy(id) {
            api.delete(this.url + '/admin/chats/' + id)
                .then(() => {
                    this.getChats();
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getEdgesForm() {
            api.get(`${this.url}/edges/${this.country_id_form}`)
                .then(resolve => {
                    this.edgesForm = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getEdgesBasic() {
            api.get(`${this.url}/edges/${this.country_id}`)
                .then(resolve => {
                    this.edges = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getChats() {
            api.get(`${this.url}/admin/chats/${this.edge_id}`)
                .then(resolve => {
                    console.log(resolve)
                    this.chats = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        query() {
            api.get(this.url + '/admin/chats')
                .then(resolve => {
                    this.countries = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getResults(page = 1) {
            api.get(`${this.url}/admin/chats/${this.edge_id}?page=${page}`)
                .then(r => {
                    this.chats = r.data;
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
