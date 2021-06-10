import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import ShowPassword from './views/ShowPassword.vue'
import Logout from './components/Logout.vue'
import CreateProfile from './views/CreateProfile.vue'


export const routes = [
    {
        name: 'Profile',
		path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: 'Login',
		path: '/login',
        component: Login,
    },
    {
        name: 'Logout',
		path: '/logout',
        component: Logout,
    },
    {
        name: 'Register',
		path: '/register',
        component: Register,
    },
    {
        name: 'Show Password',
		path: '/showpassword/:id',
        component: ShowPassword,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: 'Create Profile',
        path: '/createprofile',
        component: CreateProfile,
        meta: {
            requiresAuth: true
        }
    }
];