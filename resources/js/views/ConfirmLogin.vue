<template>
    <div class="login-page">
        <div class="login-form">
            <div class="logo">
                <div class="logo-background">
                    <font-awesome-icon icon="key" />
                </div>
            </div>
            <h3 class="title">2FA Verify</h3>
            <p style="text-align: center">Please Check Your Inbox</p>
            <form v-on:submit.prevent="submitForm">
                <b-input type="text" v-model="login_token" placeholder="Token" />
                <b-button variant="primary" class="login-button" type="submit">Verify</b-button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ConfirmLogin',

    data() {
        return {
            login_token: null
        }
    },
    methods: {
        async submitForm() {
            let email = window.localStorage.getItem('email');

            try {
                let response = await axios.post('/api/auth/confirm_login', {
                    'email': email,
                    'login_token': this.login_token
                });

                if (response.status == 200) {
                    window.localStorage.removeItem('authUser');
                    window.localStorage.setItem('authUser', JSON.stringify(response.data));
                    if (JSON.parse(JSON.stringify(response.data)).user.is_admin == 1 ||
                        JSON.parse(JSON.stringify(response.data)).user.is_staff == 1) {
                        window.localStorage.setItem('is_staff', true);
                    }

                    window.location.replace('/');
                } else {
                    window.location.replace('/login');
                }
            } catch (error) {
                console.log(error.response);
            }

            window.localStorage.removeItem('email');
        }
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/login.scss';
</style>