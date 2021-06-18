<template>
    <div class="login-page">
        <div class="login-form">
            <div class="logo">
                <div class="logo-background">
                    <font-awesome-icon icon="key" />
                </div>
            </div>
            <h3 class="title">Reset Password</h3>
            <b-alert variant="success" show v-if="messages.success">{{ messages.success }} <router-link to="/login">Login</router-link></b-alert>
            <form v-on:submit.prevent="submitForm">
                <b-input type="password" v-model="form.password" placeholder="Password" />
                <b-button variant="primary" class="login-button" type="submit">Reset Password</b-button>
            </form>
            <div class="buttons">
                <b-button href="/login" variant="secondary" type="button">Login To Your Account</b-button>
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
                password: '',
            },
            messages: {
                success: ''
            }
        }
    },
    mounted() {
        this.isTokenValid();
    },
    methods: {
        isTokenValid() {
            axios.get(`/api/checkresettoken/${this.$route.params.token}`)
            .then(res => {
                return;
            })
            .catch(error => {
                this.$router.push('/forgetpassword');
            });
        },
        submitForm() {
            axios.post('/api/resetpassword', {
                "resettoken": this.$route.params.token,
                "password": this.form.password
            })
            .then(res => {
                this.messages.success = res.data.message;
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/login.scss';
</style>