<template>
    <header class="col-12 bg-info h-50">
        <div class="row">
            <div class="col-11 col-sm-6 text-center text-sm-start p-2">
                <router-link :to="{name: 'home'}"><h1 class="ms-3">CITY.LOC</h1></router-link>
            </div>
            <div class="col-11 col-sm-6 text-end p-2">
                <router-link :to="{name: 'account'}" class="p-1 m-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                         class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    </svg>
                </router-link>
                <a @click.prevent="logout()" class="p-1 m-1 btn me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                         class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd"
                              d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>

            </div>
        </div>


        <div class="col-12 p-2">
            <nav-component></nav-component>
        </div>
    </header>
</template>

<script>
import api from "@/assets/api";
import NavComponent from "@/components/NavComponent";

export default {
    name: "HeaderComponent",


    components: {
        NavComponent: NavComponent,
    },

    computed:{
        url(){
            return this.$store.getters.getUrl;
        }
    },

    methods: {
        logout() {
            api.post(this.url+'/auth/logout')
                .then(()=>{
                    sessionStorage.clear();
                    this.$router.push({name: 'login'});
                })
                .catch(error=>{
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>
a{
    text-decoration: none;
    color: black;
}

a:hover{
    text-decoration: none;
    color: black;
}
</style>
