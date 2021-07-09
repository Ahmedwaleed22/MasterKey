<template>
    <div class="login-page">
        <div class="login-form">
            <div class="logo">
                <div class="logo-background">
                    <font-awesome-icon icon="key" />
                </div>
            </div>
            <h3 class="title">Register</h3>
            <div class="errors" v-if="messages.errors">
                <b-alert
                    variant="danger"
                    show
                    v-for="(error, n) in messages.errors"
                    :key="n"
                >
                    {{ error[0] }}
                </b-alert>
            </div>
            <b-alert variant="success" show v-if="messages.success">{{ messages.success }} <router-link to="/login">Login</router-link></b-alert>
            <form v-on:submit.prevent="submitForm">
                <b-input type="text" v-model="form.username" placeholder="Username" />
                <b-input type="email" v-model="form.email" placeholder="Email" />
                <b-input type="password" v-model="form.password" placeholder="Password" />
                <b-button variant="primary" class="login-button" type="submit">Register</b-button>
            </form>
            <div class="buttons">
                <b-button href="/login" variant="secondary" type="button">Sign In</b-button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Register',
    data() {
        return {
            form: {
                username: '',
                email: '',
                password: '',
            },
            messages: {
                errors: null,
                success: ''
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
    },
    methods: {
        submitForm() {
            axios.post('/api/auth/register', this.form)
            .then(res => {
                this.messages.errors = '';
                this.messages.success = 'Check Your Inbox To Verify Your Account';
            }).catch(error => {
                this.messages.success = '';
                this.messages.errors = error.response.data;
                this.form.password = null;
            });
        },
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/login.scss';
</style>