<template>
    <div class="col-12 h-auto p-5">
        <h3>Login</h3>
        <div class="col-11 col-sm-5 p-5 m-auto bg-info radius">
            <div class="text-danger fs-3">{{ error }}</div>
            <input class="form-control p-3 mt-3 m-auto" type="email" placeholder="Email" v-model.trim="email">
            <input class="form-control p-3 mt-3 m-auto"
                   :type="show ? 'text' : 'password'" placeholder="Password" v-model.trim="password">

            <input type="checkbox" class="m-auto mt-3 p-3" v-model="show">
            <span> Show password</span>
            <div class="mt-3">
                <button @click="login()" class="btn bg-primary">Login</button>
            </div>
        </div>
    </div>
</template>

<script>

import api from "@/assets/axios/api";

export default {
    name: "LoginView",

    data() {
        return {
            email: '',
            password: '',
            show: false,
            error: ''
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl + '/auth/login'
        }
    },

    methods: {
        login() {
            this.error = '';
            if (this.email === '' || this.password === '') {
                this.error = 'Not all fields are filled';
            } else {
                api.post(this.url, {
                    email: this.email,
                    password: this.password
                })
                    .then(resolve => {
                        this.password = '';
                        this.email = '';

                        if (resolve.data.user.role.role !== 'admin') {
                            this.error = 'You are not an administrator';
                        } else {
                            sessionStorage.setItem('token', resolve.data.access_token);
                            this.$router.push({name: 'home'});
                        }

                    })
                    .catch(() => {
                        this.error = 'Invalid email or password';
                    });
            }

        }
    }
}
</script>
