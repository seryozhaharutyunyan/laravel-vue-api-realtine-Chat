<template>
    <header-component></header-component>
    <div class="col-10 m-auto mt-5">
        <h1>Users</h1>
        <div class="d-flex mt-3 col-12 text-center justify-content-center ">
            <div class="col-sm-8 col-12 m-sm-auto">
                <div class="col-12 col-sm-6 mb-3 p-1 m-1 ">
                    <input ref="search" type="search" class="form-control border-3" placeholder="Search User(name or email)"
                           @input="search($event.target)">
                </div>
                <template v-if="showSearch">
                    <div class="col-12 col-sm-4 text-start text-danger ts-3">
                        {{ success }}
                    </div>
                    <div class="row bg-stabdart radius p-0 mb-3" v-for="(user, key) in users.data" :key="key">
                        <div class="col-12 col-sm-4">
                            <img class="radius mt-2 mb-2" :src="user.image.url" alt="img">
                        </div>

                        <div class="col-12 col-sm-8">
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Name: {{ user.name }} </span>
                            </div>
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Email: {{ user.email }}</span>
                            </div>
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Date of birth: {{ user.age }}</span>
                            </div>
                            <div class="row">
                                <div class="col-2 text-center m-3">
                                    <template v-if="user.role.role!=='admin'">
                                        <a v-if="user.block" @click="block(user.id)" class="text-danger btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                 fill="currentColor"
                                                 class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                            </svg>
                                        </a>
                                        <a v-else @click="block(user.id)" class="text-info btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                 fill="currentColor"
                                                 class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        </a>
                                    </template>
                                </div>
                                <div class="col-6 text-center m-3">
                                    <a v-if="!show(user.id)" @click="setData(user)" class="text-success btn border-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                             fill="currentColor"
                                             class="bi bi-segmented-nav" viewBox="0 0 16 16">
                                            <path
                                                d="M0 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm6 3h4V5H6v4zm9-1V6a1 1 0 0 0-1-1h-3v4h3a1 1 0 0 0 1-1z"/>
                                        </svg>
                                    </a>
                                    <div v-else>
                                        <select class="form-control-sm p-2 me-1" v-model="role_id">
                                            <option value="" disabled>Role</option>
                                            <option v-for="(role, key) in roles" :value="role.id" :key="key">
                                                {{ role.role }}
                                            </option>
                                        </select>
                                        <button @click="updateRole(user.id)" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                                <path
                                                    d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                                <div class="col-2 text-center m-3">
                                    <a v-if="user.role.role!=='admin'" class="text-danger btn border-0"
                                       @click="destroy(user.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                             fill="currentColor"
                                             class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                        <pagination :pagination="users" :callback="getResultsSearch" :size="'small'">

                        </pagination>
                    </div>
                </template>
                <template v-else>
                    <div class="col-12 col-sm-6 mb-3 p-1 m-1 ">
                        <select class="form-control p-2 me-1" v-model="country_id" @change="getUsers()">
                            <option value="" disabled>Countries</option>
                            <option v-for="(country, key) in countries" :value="country.id" :key="key">
                                {{ country.name }}
                            </option>
                        </select>
                    </div>
                    <div class="row bg-stabdart radius p-0 mb-3" v-for="(user, key) in users.data" :key="key">
                        <div class="col-12 col-sm-4">
                            <img class="radius mt-2 mb-2" :src="user.image.url" alt="img">
                        </div>

                        <div class="col-12 col-sm-8">
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Name: {{ user.name }} </span>
                            </div>
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Email: {{ user.email }}</span>
                            </div>
                            <div class="col-12 text-start m-3">
                                <span class="fs-3 m-1 p-1">Date of birth: {{ user.age }}</span>
                            </div>
                            <div class="row">
                                <div class="col-2 text-center m-3">
                                    <template v-if="user.role.role!=='admin'">
                                        <a v-if="user.block" @click="block(user.id)" class="text-danger btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                 fill="currentColor"
                                                 class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                            </svg>
                                        </a>
                                        <a v-else @click="block(user.id)" class="text-info btn border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                 fill="currentColor"
                                                 class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        </a>
                                    </template>
                                </div>
                                <div class="col-6 text-center m-3">
                                    <a v-if="!show(user.id)" @click="setData(user)" class="text-success btn border-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                             fill="currentColor"
                                             class="bi bi-segmented-nav" viewBox="0 0 16 16">
                                            <path
                                                d="M0 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm6 3h4V5H6v4zm9-1V6a1 1 0 0 0-1-1h-3v4h3a1 1 0 0 0 1-1z"/>
                                        </svg>
                                    </a>
                                    <div v-else>
                                        <select class="form-control-sm p-2 me-1" v-model="role_id">
                                            <option value="" disabled>Role</option>
                                            <option v-for="(role, key) in roles" :value="role.id" :key="key">
                                                {{ role.role }}
                                            </option>
                                        </select>
                                        <button @click="updateRole(user.id)" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                                <path
                                                    d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                                <div class="col-2 text-center m-3">
                                    <a v-if="user.role.role!=='admin'" class="text-danger btn border-0"
                                       @click="destroy(user.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                             fill="currentColor"
                                             class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                        <pagination :pagination="users" :callback="getResults" :size="'small'">

                        </pagination>
                    </div>
                </template>

            </div>
        </div>


    </div>

</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import PaginationComponent from "@/components/PaginationComponent";
import api from "@/assets/axios/api";

export default {
    name: "UsersView",
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
            users: {},
            showUsers: false,
            countries: {},
            country_id: '',
            updateId: '',
            roles: {},
            role_id: '',
            showSearch: false,
            success: '',
        };
    },

    methods: {
        show(id) {
            return id === this.updateId
        },

        getData() {
            if (this.country_id) {
                this.getUsers();
            } else {
                this.search(this.$refs.search);
            }
        },

        setData(user) {
            this.updateId = user.id;
            this.role_id = user.role_id;
        },

        updateRole(id) {
            api.post(`${this.url}/admin/users/role/${id}`, {
                role_id: this.role_id
            })
                .then(() => {
                    this.role_id = '';
                    this.updateId = '';
                    this.getData();
                })
                .catch(error => {
                    console.log(error);
                })
        },

        block(id) {
            api.get(`${this.url}/admin/users/block/${id}`)
                .then(() => {
                    this.getData();
                })
                .catch(error => {
                    console.log(error);
                })
        },

        destroy(id) {
            api.delete(`${this.url}/admin/users/${id}`)
                .then(() => {
                    this.getData();
                })
                .catch(error => {
                    console.log(error);
                })
        },

        search(event) {
            this.users = {};
            this.country_id = '';
            this.showSearch = true;
            let text = event.value;
            if (text.length > 2) {
                api.post(`${this.url}/admin/users/search`, {
                    text: text
                })
                    .then((resolve) => {
                        this.success = '';
                        if (resolve.data.data.length > 0) {
                            this.users = resolve.data
                            this.paginate = true;
                        } else {
                            this.users = {};
                            this.success = 'No result'
                        }
                        this.showSearch = true;
                    })
                    .catch(() => {
                        this.success = 'No result';
                    })
            } else if (text.length <= 2 && text.length > 0) {
                return;
            } else if (text.length === 0) {
                this.showSearch = false;
                this.users = {};
            }
        },

        query() {
            api.get(`${this.url}/admin/users`)
                .then(resolve => {
                    this.countries = resolve.data.countries;
                    this.roles = resolve.data.roles;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getUsers() {
            this.showUsers = false;
            api.get(`${this.url}/users/${this.country_id}`)
                .then(resolve => {
                    this.users = resolve.data;
                    if (resolve.data.length) {
                        this.showUsers = true;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getResults(page = 1) {
            api.get(`${this.url}/users/${this.country_id}?page=${page}`)
                .then(r => {
                    this.users = r.data;
                });
        },

        getResultsSearch(page = 1) {
            api.post(`${this.url}/admin/users/search?page=${page}`)
                .then(r => {
                    this.users = r.data;
                });
        },
    },

    created() {
        this.query();
    }
}
</script>

<style scoped>
img {
    width: 100%;
    height: 250px;
}

.bg-stabdart {
    background-color: lightsteelblue;
}

input[type=search] {
    border: 2px solid black;
}
</style>
