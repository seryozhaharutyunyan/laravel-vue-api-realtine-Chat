<template>
    <div class="col-11 m-auto mt-5 p-3">
        <h2>Chat name: {{ chat.name }}</h2>
        <div class="row">
            <div class="col-11 col-sm-4 m-auto mt-3 text-start">
                <div class="m-auto col-12 mt-2 mb-2 ">
                    <textarea v-model.trim="message" class="form-control border-2 radius"
                              placeholder="Message" @keydown="action()"></textarea>
                    <div class="text-danger">{{ error }}</div>
                    <button class="btn-success btn m-2 p-2" @click="send()">Send</button>
                </div>
                <div class="m-auto col-12 mt-2 mb-2 ">
                    <ul>
                        <template v-for="u of activeUsers" :key="u">
                            <li class="btn border-0 col-12" @click="add(u)" v-if="u.id!==user.id">
                                {{ u.name }}
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-sm-8 m-auto">
                <div class="m-auto col-10 mt-2 mb-2 p-3 chat">
                    <div v-if="isActive" class="fs-6">someone is typing...</div>
                    <div class="text-start mt-3 border p-3" v-for="m in messages" :key="m">
                        <h3 class="text-success">{{ m.user.name }}</h3>
                        <div>{{ m.message }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
import Echo from "laravel-echo";
import User from "@/mixins/User";
import api from "@/assets/api";

window.Pusher = require("pusher-js");
window.Echo = new Echo({
    authEndpoint: `http://city.loc/api/broadcasting/auth`,
    broadcaster: 'pusher',
    key: 'e91dbdfd8a7f9ab795ed',
    wsHost: "127.0.0.1",
    authHost: "127.0.0.1",
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    auth: {
        headers: {
            Authorization: "Bearer " + sessionStorage.getItem('token')
        }
    }

})

export default {
    name: "ChatView",

    mixins: [User],

    data() {
        return {
            message: '',
            messages: {},
            id: this.$route.params.id,
            chat:'',
            error: '',
            isActive: false,
            typingTimer: false,
            activeUsers: {},
        }
    },

    computed: {
        channel() {
            return window.Echo.join(`chat.${this.id}`);
        }
    },

    methods: {
        send() {
            this.error = '';
            api.post(`${this.url}/basic/chat`, {
                message: this.message,
                chat_id: this.id,
                user_id: this.user.id,
            })
                .then(() => {
                    this.message = '';
                })
                .catch(error => {
                    this.error = error.response.data.message;
                })
        },

        add(user) {
            if (user.id !== this.user.id) {
                this.message = `${user.name}: `;
            }

        },

        connect() {
            this.channel
                .here(users => {
                    console.log(users)
                    this.activeUsers = users;
                })
                .joining(user => {
                    console.log(1,user)
                    this.activeUsers=this.activeUsers.filter((v)=>{
                        return v.id!==user.id;
                    });
                    this.activeUsers.push(user);
                })
                .leaving(user => {
                    console.log(2,user);
                   this.activeUsers=this.activeUsers.filter((v)=>{
                        return v.id!==user.id;
                    });
                })
                .listen('NewMessage', (e) => {
                    this.messages = e.messages;
                    this.isActive = false;
                })
                .listenForWhisper('typing', () => {
                    this.isActive = true;
                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                    this.typingTimer = setTimeout(() => {
                        this.isActive = false;
                    }, 1000)
                })
        },

        action() {
            this.channel
                .whisper('typing', {
                    name: this.user.name,
                })
        },

        query() {
            api.get(`${this.url}/basic/chat/${this.id}`)
                .then(resolve => {
                    this.messages = resolve.data.messages;
                    this.chat=resolve.data.chat;
                    this.connect();
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },

    created() {
        this.connect();
    },

    beforeUnmount() {
        window.Echo.leave(`chat.${this.id}`);
    }

}
</script>

<style scoped>
.chat {
    min-height: 200px;
    border-radius: 15px;
    border: 2px solid #718096;
}

.border {
    border-radius: 5px;
    border: 2px solid black;
}
</style>
