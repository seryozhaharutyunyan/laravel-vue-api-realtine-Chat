<template>
    <div class="col-12 h-auto p-5">
        <h3>Restore password</h3>
        <div class="col-11 col-sm-5 p-5 m-auto bg-info radius">
            <div class="fs-3">{{success}}</div>
            <input class="form-control p-3 mt-3 m-auto" type="email" placeholder="Email" v-model.trim="email"
                   :class="errorEmail ? 'is-invalid': ''">
            <div class="text-danger text-start">{{ errorEmail }}</div>
            <div class="col-5 col-sm-3 m-3 p-3 bg-light">{{ captcha }}</div>

            <input class="form-control p-3 mt-3 m-auto" type="text" placeholder="Captcha"
                v-model.trim="inputCaptcha" :class="errorCaptcha ? 'is-invalid': ''">
            <div class="text-start text-danger">{{errorCaptcha}}</div>
            <div class="mt-3">
                <button @click="reset()" class="btn bg-primary">Restore password</button>
            </div>

            <div class="mt-3">
                <router-link :to="{name: 'registration'}" class="btn m-1 p-2 ">Registration</router-link>
                <router-link :to="{name: 'restore-password'}" class="btn m-1 p-2">Restore password</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "RestorePasswordView",

    data() {
        return {
            email: '',
            errorCaptcha: '',
            errorEmail:'',
            captcha: '',
            inputCaptcha: '',
            success: '',
        }
    },

    computed: {
        url() {
            return `${this.$store.getters.getUrl}/registration/reset`
        }
    },

    methods: {
        reset() {
            this.errorCaptcha = '';
            this.errorEmail='';
            if(this.email===''){
                this.errorEmail='The email field is required.';
            }
            if (this.inputCaptcha === this.captcha) {
                axios.post(this.url,{
                    email: this.email
                })
                .then(resolve=>{
                    this.captcha = '';
                    this.email = '';
                    this.inputCaptcha='';
                    this.getCaptcha();
                    this.success=resolve.data;

                    setInterval(()=>{
                        this.$router.push({name: 'login'})
                    }, 8000)

                })
                .catch(error=>{
                    this.errorEmail=error.response.data.message;
                })
            } else {
                this.captcha = '';
                this.inputCaptcha='';
                this.getCaptcha();
                this.errorCaptcha = 'Not correct captcha!!!!';
            }

        },

        setCaptcha() {
            let result = '';
            let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let charactersLength = characters.length;
            for (let i = 0; i < 7; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },

        getCaptcha() {
            this.captcha = this.setCaptcha();
        }
    },

    created() {
        this.getCaptcha()
    }
}
</script>

<style scoped>

</style>
