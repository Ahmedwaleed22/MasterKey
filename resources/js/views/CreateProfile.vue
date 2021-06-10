<template>
    <div class="show-password">
        <Navbar />
        <h1 id="main-page-title">Create Your <span class="primary-text">MasterKey</span></h1>
		<p id="main-page-description">you can create your password profiles from here. all of your passwords will be encrypted and secure.</p>
        <p id="main-remember-text">(remember we will never ask you for your password via email or any social media platforms)</p>
        <div id="createprofilecontent" class="content">
            <div class="app-field">
                <b-form-select v-model="password.app">
                    <b-form-select-option value="" selected disabled>Select App</b-form-select-option>
                    <b-form-select-option v-for="(app, n) in apps" :key="n" :value="app.id">{{ app.name }}</b-form-select-option>
                </b-form-select>
            </div>
            <div class="password-field">
                <b-input readonly id="profile-password" type="text" :value="password.text" />
                <b-button @click.stop.prevent="copyPassword()" class="visibility-btn" variant="info" type="button">Copy</b-button>
                <b-button variant="danger" type="button" @click.stop.prevent="SavePassword()">Save</b-button>
            </div>
            <b-container>
                <b-row>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="extralow" name="securitylevel">Extra Low Security Level</b-form-radio>
                    </b-col>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="low" name="securitylevel">Low Security Level</b-form-radio>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="medium" name="securitylevel">Medium Security Level</b-form-radio>
                    </b-col>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="natural" name="securitylevel">Natural Security Level</b-form-radio>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="high" name="securitylevel">High Security Level</b-form-radio>
                    </b-col>
                    <b-col>
                        <b-form-radio v-model="strength" type="radio" value="extrahigh" name="securitylevel">Extra High Security Level</b-form-radio>
                    </b-col>
                </b-row>
            </b-container>
        </div>
        <SameCategory title="Some Of Your <span style='color: red'>MasterKeys</span>" />
        <FlashMessage :position="'right bottom'"></FlashMessage>
    </div>
</template>

<script>
import SameCategory from '../components/SameCategory';
import Navbar from '../components/Navbar';

export default {
    name: 'ShowPassword',
    components: {
        SameCategory,
        Navbar
    },
    data() {
        return {
            password: {
                text: '',
                app: '',
            },
            apps: null,
            strength: 'natural',
        }
    },
    mounted() {
        this.generate(32);

        axios.get('/api/apps/all')
        .then(res => this.apps = res.data)
        .catch(function (error) {
            console.log(error);
        });
    },
    methods: {
        generate(length) {
            var result = [];
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&*^%$#-_+=';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
            result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
            }
            this.password.text = result.join('');
        },
        copyPassword() {
            let field = document.getElementById('profile-password');
            field.setAttribute('type', 'text');
            this.password.is_shown = true;
            field.select();
            document.execCommand("copy");
        },
        SavePassword() {
            let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

            axios.post('/api/passwords', {
                password: this.password.text,
                app: this.password.app
            }, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            })
            .then(res => {
                window.localStorage.setItem('successMSG', JSON.stringify({
                    title: 'Profile Created Successfully',
                    message: 'Hoorah, We wish you secure life'
                }));
                this.$router.push('/');
            })
            .catch(error => {
                if (this.password.app == null || this.password.app == "") {
                    this.flashMessage.info({
                        title: 'You forgot something!',
                        message: 'Please fill out the app field',
                        icon: '/img/icons/info.svg',
                    });
                } else {
                    this.flashMessage.error({
                        title: 'There Is An Error!',
                        message: 'Oh, There is an error while creating your password profile',
                        icon: '/img/icons/error.svg',
                    });
                }
            });
        }
    },
    watch: {
        strength: function (val) {
            switch(val) {
                case 'extralow':
                    this.generate(8);
                    break;
                case 'low':
                    this.generate(16);
                    break;
                case 'medium':
                    this.generate(24);
                    break;
                case 'natural':
                    this.generate(32);
                    break;
                case 'high':
                    this.generate(48);
                    break;
                case 'extrahigh':
                    this.generate(64);
                    break;
            } 
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '/scss/createprofile.scss';
</style>