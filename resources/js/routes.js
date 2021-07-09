import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import ShowPassword from './views/ShowPassword.vue'
import Logout from './components/Logout.js'
import CreateProfile from './views/CreateProfile.vue'
import Suggestions from './views/Suggestions.vue'
import ForgetPassword from './views/ForgetPassword.vue'
import ResetPassword from './views/ResetPassword.vue'
import ConfirmLogin from './views/ConfirmLogin.vue'
import NotFound from './errors/NotFound.vue'

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
        name: 'Confirm Login',
        path: '/nextsteplogin',
        component: ConfirmLogin
    },
    {
        name: 'Register',
		path: '/register',
        component: Register,
    },
    {
        name: 'Forget Password',
        path: '/forgetpassword',
        component: ForgetPassword
    },
    {
        name: 'Reset Password',
        path: '/resetpassword/:token',
        component: ResetPassword
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
    },
    // {
    //     name: 'Pricing',
    //     path: '/pricing',
    //     component: Pricing
    // },
    {
        name: 'Suggestions',
        path: '/suggestions',
        component: Suggestions,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: 'NotFound',
        path: '*',
        component: NotFound
    },
    // {
    //     name: 'Contact',
    //     path: '/contact',
    //     component: Contact,
    //     meta: {
    //         requiresAuth: true
    //     }
    // }
];