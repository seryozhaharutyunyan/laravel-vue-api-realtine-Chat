import axios from "axios";
import store from "@/store";
import router from "@/router";

const api = axios.create();
api.interceptors.request.use(
    (config) => {
        if (sessionStorage.getItem('token')) {
            config.headers.authorization = `Bearer ${sessionStorage.getItem('token')}`;
        }

        return config;
    },
    (error) => {
        console.log(error)
    });

api.interceptors.response.use(
    (response)=>{
        return response;
    },
   (error) => {
        if (error.response.data.message==='Unauthenticated.') {
            return axios.post(store.getters.getUrl+'/auth/refresh',{},{
                headers:{
                    authorization: `Bearer ${sessionStorage.getItem('token')}`
                }
            }).then(r => {
                console.log(r);
                sessionStorage.setItem('token', r.data.access_token);

                error.config.headers.authorization = `Bearer ${sessionStorage.getItem('token')}`
                return api.request(error.config);
            });
        }else if(error.response.data.message==='The token has been blacklisted'){
            sessionStorage.clear();
            router.push({name: 'login'});
        }else{
            return Promise.reject(error);
        }
    })

export default api;
