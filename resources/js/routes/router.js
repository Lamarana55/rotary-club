import Pageparent from "../components/index.vue"
import Login from "../components/auth/login.vue"
import Utilisateur from "../users/index.vue"
import addUtilisateur from "../users/add.vue"

export const routes = [

    {
        path: '/',
        component: Pageparent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/utilisateur',
        name: 'utilisateur',
        component: Utilisateur,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/add-utilisateur',
        name: 'add-utilisateur',
        component: addUtilisateur,
        meta: {
            requiresAuth: true
        }
    },
];
