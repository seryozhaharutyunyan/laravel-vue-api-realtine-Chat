import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from "@/views/LoginView";
import AccountView from "@/views/AccountView";
import CountriesView from "@/views/CountriesView";
import EdgesView from "@/views/EdgesView";
import RolesView from "@/views/RolesView";
import UsersView from "@/views/UsersView";
import ChatsView from "@/views/ChatsView";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },

    {
        path: '/login',
        name: 'login',
        component: LoginView
    },

    {
        path: '/account',
        name: 'account',
        component: AccountView
    },

    {
        path: '/countries',
        name: 'countries',
        component: CountriesView
    },

    {
        path: '/edges',
        name: 'edges',
        component: EdgesView
    },

    {
        path: '/roles',
        name: 'roles',
        component: RolesView
    },

    {
        path: '/users',
        name: 'users',
        component: UsersView
    },

    {
        path: '/chats',
        name: 'chats',
        component: ChatsView
    },

    {
        path: "/:pathMatch(.*)*",
        redirect: '/'
    },
]

const router = createRouter({
    history: createWebHistory('/admin/'),
    routes
});

router.beforeEach((to) => {
    const token = sessionStorage.getItem('token');
    if (to.name !== 'login') {
        if (!token) {
            return {
                name: 'login'
            };
        }
    }

    if (to.name === 'login') {
        if (token) {
            return {
                name: 'home'
            };
        }
    }
});

export default router
