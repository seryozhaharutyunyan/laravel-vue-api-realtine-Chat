<template>
    <div class="col-sm-5 col-9 mt-3 text-center m-auto p-3">
        <h2>Edges for country</h2>
        <select class="form-control m-3  p-1" v-model="edge_id" @change="queryChats()">
            <option value="" disabled>Edges</option>
            <option v-for="(edge, key) in edges" :value="edge.id" :key="key">
                {{ edge.name }}
            </option>
        </select>
    </div>
    <div class="col-10 col-sm-6 m-auto">
        <template v-for="chat in chats" :key="chat">
            <router-link class="btn btn-success m-2 p-2" :to="{name: 'chat', params:{id: chat.id}}">{{ chat.name }}</router-link>
        </template>
    </div>

</template>

<script>
import api from "@/assets/api";
import User from "@/mixins/User";

export default {
    name: "ChatsView",

    mixins: [User],

    data() {
        return {
            edge_id: '',
            edges: {},
            chats: {},
        }
    },


    methods: {

        query() {
            api.get(`${this.url}/basic/${this.user.country_id}`)
                .then(resolve => {
                    this.edges = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        queryChats() {
            api.get(`${this.url}/basic/show/${this.edge_id}`)
                .then(resolve => {
                    this.chats = resolve.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },

}
</script>
