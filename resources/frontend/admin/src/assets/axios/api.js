import axios from "axios";
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
        if (error.response.data.message === 'Token has expired') {
            sessionStorage.clear();
            router.push({name: 'login'});
        }else if(error.response.data.message === 'Unauthorized'){
            sessionStorage.clear();
            router.push({name: 'login'});
        }else{
            return Promise.reject(error);
        }
    })

export default api;
