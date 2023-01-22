import api from "@/assets/axios/api";
import store from "@/store";

export default {
    data(){
        return {
            user:{}
        }
    },

    methods:{
        getUser(){
            api.post(store.getters.getUrl+'/auth/me')
                .catch((error)=>{
                    console.log(error)
                })
        }
    },

    created() {
        this.getUser();
    }
}
