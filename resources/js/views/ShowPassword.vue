<template>
    <div class="show-password" v-if="user.username != null">
        <Navbar />
        <h1 id="main-page-title">{{ app.name }}'s <span class="primary-text">MasterKey</span></h1>
        <p id="main-page-description">{{ app.description }}</p>
        <div id="showpassword" class="content">
            <div class="password-field">
                <b-input readonly id="profile-password" type="password" :value="password.text" />
                <b-button class="visibility-btn" variant="info" type="button" @click="showPassword()" v-if="!password.is_shown">Show</b-button>
                <b-button class="visibility-btn" variant="info" type="button" @click="hidePassword()" v-else>Hide</b-button>
                <b-button variant="danger" type="button" @click.stop.prevent="copyPassword">Copy</b-button>
            </div>
        </div>
        <section id="same-category">
            <h1 class="title">From Same <span class="primary-text">Category</span></h1>
            <b-container>
                <div id="password-profiles">
                    <div class="profile" v-for="(profile, n) in same_category" :key="n">
                        <img :src="`${profile.app.logo}`" />
                        <h3>{{ profile.app.name }}</h3>
                        <p class="description">{{ profile.app.short_description }}</p>
                        <a :href="`/showpassword/${profile.id}`" class="show-password">
                            <font-awesome-icon icon="key" />
                        </a>
                    </div>
                </div>
            </b-container>
        </section>
    </div>
</template>

<script>
import Navbar from '../components/Navbar';

export default {
    name: 'ShowPassword',
    components: {
        Navbar
    },
    data() {
        return {
            app: {
                name: null,
                description: null,
            },
            password: {
                text: null,
                is_shown: false,
            },
            user: {
				username: null
			},
            same_category: null
        }
    },
    mounted() {
        this.getUsername();
        const id = this.$route.params.id;
        this.loadData(id);
    },
    methods: {
        showPassword() {
            let field = document.getElementById('profile-password');
            field.setAttribute('type', 'text');
            this.password.is_shown = true;
        },
        hidePassword() {
            let field = document.getElementById('profile-password');
            field.setAttribute('type', 'password');
            this.password.is_shown = false;
        },
        copyPassword() {
            let field = document.getElementById('profile-password');
            field.setAttribute('type', 'text');
            this.password.is_shown = true;
            field.select();
            document.execCommand("copy");
        },
        loadData(id) {
            let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

            axios.get(`/api/passwords/${id}`, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            })
            .then(res => {
                this.app.name = res.data.app_name;
                this.app.description = res.data.description;
                this.password.text = res.data.password;
                this.same_category = res.data.form_same_category
            })
            .catch(error => {
                console.log(error);
                this.$router.push('/');
            });
        },
        getUsername() {
			let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

			axios.get('/api/auth/user-profile', {
				headers: {
					"Authorization": `Bearer ${token}`
				}
			})
			.then(res => {
				this.user.username = res.data.username
			})
			.catch(err => {
				this.$router.push('/login');
			});
		}
    }
}
</script>

<style lang="scss" scoped>
    @import '/scss/showpassword.scss';
</style>