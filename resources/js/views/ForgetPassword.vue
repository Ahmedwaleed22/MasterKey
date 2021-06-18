<template>
    <div class="login-page">
        <div class="login-form">
            <div class="logo">
                <div class="logo-background">
                    <font-awesome-icon icon="key" />
                </div>
            </div>
            <h3 class="title">Forget Password</h3>
            <b-alert variant="danger" show v-if="messages.error">{{ messages.error }}</b-alert>
            <b-alert variant="success" show v-if="messages.success">{{ messages.success }}</b-alert>
            <form v-on:submit.prevent="submitForm">
                <b-input type="email" v-model="form.email" placeholder="Email" />
                <b-button variant="primary" class="login-button" type="submit">Send Reset Email</b-button>
            </form>
            <div class="buttons">
                <b-button href="/login" variant="secondary" type="button">Login To Your Account</b-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ForgetPassword',

    data() {
        return {
            form: {
                email: null,
                password: null,
            },
            messages: {
                success: null,
                error: null
            }
        }
    },
    methods: {
        submitForm() {
            if (this.form.email == null) {
                this.messages.success = null;
                this.messages.error = 'Email Can\'t Be Empty';
            } else {
                axios.post('/api/forgetpassword', {
                    "email": this.form.email
                }).then(res => {
                    this.messages.error = null;
                    this.messages.success = res.data.message;
                    this.form.email = null;
                }).catch(error => {
                    this.messages.success = null;
                    this.messages.error = error.response.data.error;
                });
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/login.scss';
</style>