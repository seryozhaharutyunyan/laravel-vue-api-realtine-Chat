<template>
    <div class="col-12 h-auto p-5">
        <h3>Update password</h3>
        <div class="col-11 col-sm-5 p-5 m-auto bg-info radius">
            <div class="text-success fs-1">{{ success }}</div>
            <input class="form-control p-3 mt-3 m-auto"
                   :type="show ? 'text' : 'password'" placeholder="Password" v-model.trim="password">
            <div class="text-danger">{{ error.password[0] }}</div>
            <input type="checkbox" class="m-auto mt-3 p-3" v-model="show">
            <span> Show password</span>
            <input class="form-control p-3 mt-3 m-auto"
                   :type="showNow ? 'text' : 'password'" placeholder="New password" v-model.trim="passwordNew">
            <div class="text-danger">{{ error.passwordNew[0] }}</div>
            <input class="form-control p-3 mt-3 m-auto"
                   :type="showNow ? 'text' : 'password'" placeholder="Confirm password" v-model.trim="passwordConfirm">
            <input type="checkbox" class="m-auto mt-3 p-3" v-model="showNow">
            <span> Show new and confirm password</span>
            <div class="mt-3">
                <button @click="update()" class="btn bg-primary m-2">Update</button>
                <router-link :to="{name: 'home'}" class="btn bg-primary m-2">Home</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import api from "@/assets/api";

export default {
    name: "AccountView",
    data() {
        return {
            password: '',
            passwordNew: '',
            passwordConfirm: '',
            show:false,
            showNow:false,
            error: {
                password: [''],
                passwordNew: [''],
            },
            success: '',
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl
        }
    },

    methods: {
        update() {
            this.error = {
                password: [''],
                passwordNew: [''],
            };
            this.success='';
            api.post(`${this.url}/account`, {
                password: this.password,
                passwordNew: this.passwordNew,
                passwordNew_confirmation: this.passwordConfirm
            })
                .then(() => {
                    this.password = '';
                    this.passwordNew = '';
                    this.passwordConfirm = '';
                    this.success = 'Password changed successfully';
                })
                .catch(errors => {
                    this.error = Object.assign(this.error, errors.response.data.errors)
                })
        }
    },

}
</script>

<style scoped>

</style>
