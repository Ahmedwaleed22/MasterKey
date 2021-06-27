<template>
    <div id="suggestions-page" v-if="user.username != null">
        <Navbar />
        <section class="main">
            <h1 class="title">We Love Hearing From You!</h1>
            <p class="description">You take an important part in our community, Your opinion and ideas is very important to us.</p>
            <div class="suggestion-form">
                <b-form @submit.prevent="createSuggestion">
                    <b-input v-model="suggestion" type="text" placeholder="Your Suggestion" />
                    <b-button type="submit" variant="danger">Suggest!</b-button>
                </b-form>
            </div>
        </section>
        <section id="suggestions">
            <SuggestionContainer title="Some Of Users <span style='color: red'>Suggestions</span>">
                <Suggestion
                    :suggestion="suggestion.suggestion"
                    :username="suggestion.user.username"
                    :date="suggestion.created_date"
                    v-for="(suggestion, n) in loaded_suggestions"
                    :key="n"
                />
            </SuggestionContainer>
        </section>
        <FlashMessage :position="'right bottom'"></FlashMessage>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import Suggestion from '../components/Suggestion.vue';
import SuggestionContainer from '../components/SuggestionsContainer.vue';

export default {
    name: 'Suggestions',
    components: {
        Navbar,
        SuggestionContainer,
        Suggestion
    },
    data() {
        return {
            suggestion: null,
            loaded_suggestions: null,
            user: {
				username: null
			}
        }
    },
    mounted() {
        this.getUsername();
        this.PlaceholderAnimation();
        this.loadData();
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
        loadData() {
            axios.get('/api/suggestions')
            .then(res => this.loaded_suggestions = res.data)
            .catch(error => console.log(error));
        },
        createSuggestion() {
            const token = JSON.parse(window.localStorage.getItem('authUser')).access_token;
            
            axios.post('/api/suggestions', {
                "suggestion": this.suggestion
            },
            {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            }).then(res => {
                this.loadData();

                this.flashMessage.success({
                    title: 'Suggestion Sent!',
                    message: 'Your Suggestion Sent Successfully To Our Team!',
                    icon: '/img/icons/success.svg',
                });

                this.suggestion = null;
            }).catch(error => {
                this.flashMessage.error({
                    title: 'There Is An Error!',
                    message: error.response.data.message,
                    icon: '/img/icons/error.svg',
                });
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
@import '/scss/suggestions.scss';
</style>
