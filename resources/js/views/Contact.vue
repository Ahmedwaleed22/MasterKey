<template>
    <div id="contactus">
        <Navbar />
        <div class="contact-form">
            <h2 class="title">Contact Us!</h2>
            <p class="description">We Love Hearing From You...</p>
            <b-form v-on:submit.prevent="submitForm">
                <b-input v-model="form.subject" required type="text" placeholder="Subject" />
                <b-input disabled :value="useremail" type="email" placeholder="Email" />
                <b-textarea v-model="form.message" required placeholder="Message..."></b-textarea>
                <vue-recaptcha
                    ref="recaptcha"
                    sitekey="6Ldb5jsbAAAAAFB3y8ZgJQCbS9VQFxvBFkZi4GBy"
                    @verify="onCaptchaVerified"
                    @expired="resetCaptcha"
                    style="margin-bottom: 10px"
                    :loadRecaptchaScript="true"
                ></vue-recaptcha>
                <b-button :disabled="form.submited" type="submit" variant="primary">Send!</b-button>
            </b-form>
        </div>
        <FlashMessage :position="'right bottom'"></FlashMessage>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import axios from 'axios';

export default {
    name: 'ContactUs',
    components: {
        Navbar,
        VueRecaptcha
    },
    data() {
        return {
            useremail: JSON.parse(window.localStorage.getItem('authUser')).user.email,
            form: {
                subject: null,
                message: null,
                submited: false
            },
            recaptcha: null
        }
    },
    mounted() {
        this.PlaceholderAnimation();
    },
    methods: {
        PlaceholderAnimation() {
            const inputs = document.querySelectorAll("input, textarea");

            inputs.forEach(input => {
                input.onfocus = () => {
                    input.setAttribute('data-placeholder', input.placeholder);
                    input.placeholder = '';
                }
                input.onblur = () => {
                    input.placeholder = input.getAttribute('data-placeholder');
                    input.setAttribute('data-placeholder', '');
                }
            })
        },
        async submitForm() {
            let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

            if (this.recaptcha != null) {
                try {
                    const res = await axios.post('/api/contact', this.form, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    this.flashMessage.success({
                        title: 'We Received Your Message!',
                        message: 'You Did It! We Received Your Message. We Will Reply Soon.',
                        icon: '/img/icons/success.svg',
                    });

                    this.form.submited = true;
                    this.form.subject = '';
                    this.form.message = '';

                } catch (err) {
                    this.flashMessage.error({
                        title: 'There Is An Error',
                        message: err.response.statusText,
                        icon: '/img/icons/error.svg',
                    });
                }
            } else {
                this.flashMessage.error({
                    title: 'There Is An Error',
                    message: 'Failed Verifying Captcha',
                    icon: '/img/icons/error.svg',
                });
            }
        },
        onCaptchaVerified(token) {
            this.recaptcha = token;
        },
        resetCaptcha() {
            this.$refs.recaptcha.reset();
        }
    }
}
</script>

<style lang="scss" scoped>
@import '/scss/contact.scss';
</style>