<template>
    <div class="login-page">
        <div class="login-form">
            <div class="logo">
                <div class="logo-background">
                    <font-awesome-icon icon="key" />
                </div>
            </div>
            <h3 class="title">Login</h3>
            <b-alert variant="danger" show v-if="messages.error">{{ messages.error }}</b-alert>
            <form v-on:submit.prevent="submitForm">
                <b-input type="email" v-model="form.email" placeholder="Email" />
                <b-input type="password" v-model="form.password" placeholder="Password" />
                <b-button variant="primary" class="login-button" type="submit">Login</b-button>
            </form>
            <div class="buttons">
                <b-button href="/forgetpassword" variant="secondary" type="button">Forgot Password</b-button>
                <b-button href="/register" variant="secondary" type="button">Sign Up</b-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            messages: {
                error: ''
            }
        }
    },
    mounted() {
        const inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.onclick = () => {
                if (input.placeholder) {
                    input.setAttribute('data-placeholder', input.placeholder);
                    input.placeholder = '';
                }
            }
            input.onblur = () => {
                input.placeholder = input.getAttribute('data-placeholder');
                input.setAttribute('data-placeholder', '');
            }
        });

        document.getElementById('app').removeAttribute('class', 'dark-mode');
    },
    methods: {
        submitForm() {
            axios.post('/api/auth/login', this.form)
            .then(res => {
                window.localStorage.removeItem('authUser');
                window.localStorage.setItem('authUser', JSON.stringify(res.data));
                if (JSON.parse(JSON.stringify(res.data)).user.is_admin == 1 ||
                    JSON.parse(JSON.stringify(res.data)).user.is_staff == 1) {
                    window.localStorage.setItem('is_staff', true);
                }
                window.location.replace('/');
            })
            .catch(error => {
                this.form.password = null;
                this.messages.error = error.response.data.message;
            });
        }
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/login.scss';
</style>