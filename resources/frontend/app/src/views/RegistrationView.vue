<template>
    <div class="col-12 h-auto p-5">
        <h3>Registration</h3>
        <div class="col-11 col-sm-5 p-5 m-auto bg-info radius">
            <div class="fs-3">{{success}}</div>
            <input class="form-control p-3 mt-3 m-auto" type="text" placeholder="Name" v-model.trim="data.name"
                   :class="error.name[0] ? 'is-invalid': ''">
            <div class="text-danger text-start">{{error.name[0]}}</div>
            <input class="form-control p-3 mt-3 m-auto" type="email" placeholder="Email" v-model.trim="data.email"
                   :class="error.email[0] ? 'is-invalid': ''">
            <div class="text-danger text-start">{{error.email[0]}}</div>
            <input class="form-control p-3 mt-3 m-auto" type="date" placeholder="Age" v-model="data.age" :max="maxDate"
                   :class="error.age[0] ? 'is-invalid': ''">
            <div class="text-danger text-start">{{error.age[0]}}</div>
            <select v-model="data.country_id" class="form-select m-auto mt-3 p-3"
                    :class="error.country_id[0] ? 'is-invalid': ''">
                <option disabled value="">Country</option>
                <option v-for="(c, k) in countries" :value="c.id" :key="k">
                    {{ c.name }}
                </option>
            </select>
            <div class="text-danger text-start">{{error.country_id[0]}}</div>
            <div @click="removeImg()" class="col-11 col-sm-6 m-auto btn">
                <div v-show="image" class="form-control  mt-3 p-1">
                    <img :src="image">
                    <span class="text-danger">Remove image</span>
                </div>
            </div>
            <input ref="image" type="file" class="form-control m-auto mt-3  p-3" accept="image/*"
                   @input="fileUpload($event)" placeholder="Image" :class="error.img[0] ? 'is-invalid': ''">
            <div class="text-danger text-start">{{error.img[0]}}</div>
            <div>
                <label class="p-3">Gender</label><br>
                <div class="text-danger text-start">{{error.gender[0]}}</div>
                <input class="form-check-input" type="radio" name="gender" v-model="data.gender"
                       value="male">
                <label class="form-check-label p-3 pt-0">Male</label><br>
                <input class="form-check-input" type="radio" name="gender" v-model="data.gender"
                       value="female">
                <label class="form-check-label p-3 pt-0">Female</label>
            </div>


            <div class="mt-3">
                <button @click="registration()" class="btn bg-primary">Registration</button>
            </div>

            <div class="mt-3">
                <router-link :to="{name: 'login'}" class="btn m-1 p-2 ">Login</router-link>
                <router-link :to="{name: 'restore-password'}" class="btn m-1 p-2">Restore password</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "RegistrationView",

    data() {
        return {
            data: {
                name: '',
                email: '',
                age: '',
                img: '',
                gender: '',
                country_id: ''
            },
            success:'',
            show: false,
            error: {
                name: [''],
                email: [''],
                age: [''],
                img: [''],
                gender: [''],
                country_id: ['']
            },
            image: '',
            countries:{},
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl+'/registration';
        },

        maxDate() {
            const date = new Date();
            let year = date.getFullYear() - 15;
            return year + '-01-01';
        }
    },

    methods: {
        registration() {
            this.error={
                name: [''],
                    email: [''],
                    age: [''],
                    img: [''],
                    gender: [''],
                    country_id: ['']
            };

            const data = new FormData();

            data.append('name', this.data.name);
            data.append('email', this.data.email);
            data.append('age', this.data.age);
            data.append('gender', this.data.gender);
            data.append('country_id', this.data.country_id);
            data.append('img', this.data.img);


            axios.post(this.url, data)
                .then(resolve => {
                    this.data={
                        name: '',
                        email: '',
                        age: '',
                        img: '',
                        gender: '',
                        country_id: ''
                    };

                    this.removeImg();

                    this.success=resolve.data

                    setInterval(()=>{
                        this.$router.push({name: 'home'});
                    },8000);
                })
                .catch((error) => {
                   if(error.response.data.message){
                       this.error=Object.assign(this.error, error.response.data.errors)
                   }
                });

        },

        fileUpload(event) {
            this.data.img = event.target.files[0];

            const reader = new FileReader();

            reader.addEventListener("load", function () {

                this.image = reader.result;

            }.bind(this), false);

            if (this.data.img) {
                if (this.data.img.name) {
                    reader.readAsDataURL(this.data.img);
                }
            }
        },

        removeImg() {
            this.image = '';
            this.data.img = '';
            this.$refs.image.value = '';
        },

        query() {
            axios.get(this.url)
                .then(resolve=>{
                    this.countries=resolve.data;
                })
                .catch(error=>{
                    console.log(error);
                })
        }
    },

    created() {
        this.query();
    }

}
</script>

<style scoped>
img {
    width: 100%;
    height: 170px;
}

</style>
