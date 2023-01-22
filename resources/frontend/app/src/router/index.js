import {createRouter, createWebHistory} from 'vue-router'

import LoginView from "@/views/LoginView";
import HomeView from "@/views/HomeView";
import RestorePasswordView from "@/views/RestorePasswordView";
import RegistrationView from "@/views/RegistrationView";
import ChatsView from "@/views/ChatsView";
import AccountView from "@/views/AccountView";
import InfoView from "@/views/InfoView";
import ChatView from "@/views/ChatView";

const routes = [
    {
        path: '/login',
        name: 'login',
        component: LoginView
    },

    {
        path: '/restore-password',
        name: 'restore-password',
        component: RestorePasswordView
    },

    {
        path: '/registration',
        name: 'registration',
        component: RegistrationView
    },

    {
        path: '/account',
        name: 'account',
        component: AccountView
    },

    {
        path: '/info',
        name: 'info',
        component: InfoView,
    },

    {
        path: '/',
        name: 'home',
        component: HomeView,
        children: [
            {
                path: '/',
                name: 'chats',
                component: ChatsView,
            },
            {
                path: '/chat/:id',
                name: 'chat',
                component: ChatView,
            },
        ]
    },


    {
        path: "/:pathMatch(.*)*",
        redirect: '/'
    }
    ,
]

const router = createRouter({
    history: createWebHistory('/'),
    routes
});

router.beforeEach((to) => {
    const token = sessionStorage.getItem('token');

    if (to.name !== 'login' && to.name !== 'restore-password' && to.name !== 'registration') {
        if (!token) {
            return {
                name: 'login'
            };
        }
    }

    if (to.name === 'login' && to.name === 'restore-password' && to.name === 'registration') {
        if (token) {
            return {
                name: 'home'
            };
        }
    }

});

export default router
