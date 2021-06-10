<template>
	<div class="homepage">
		<vue-confirm-dialog></vue-confirm-dialog>
		<Navbar />
		<h1 id="main-page-title">your <span class="primary-color">profile</span></h1>
		<p id="main-page-description">you can create your password profiles from here. all of your passwords will be encrypted.</p>
		<p id="main-remember-text">(remember we will never ask you for your password via email or any social media platforms)</p>
		<b-container>
			<vue-context ref="menu" style="background: transparent !important; border: none">
				<ul slot-scope="child">
					<li>
						<router-link :to="`/showpassword/${child.data}`">Open</router-link>
					</li>
					<li>
						<a href="#" @click.prevent="deleteProfile($event.target.innerHTML, child.data)">Delete</a>
					</li>
				</ul>
			</vue-context>
			<div id="password-profiles">
				<div class="profile" v-for="(profile, n) in this.profileData.profiles" :key="n" @contextmenu.prevent="$refs.menu.open($event, profile.id)">
					<img :src="`/img/apps/${profile.app.logo}`" />
					<h3>{{ profile.app.name }}</h3>
					<p class="description">{{ profile.app.short_description }}</p>
					<router-link :to="`/showpassword/${profile.id}`" class="show-password">
						<font-awesome-icon icon="key" />
					</router-link>
				</div>
			</div>
		</b-container>
		<b-pagination
			v-model="pagination.currentPage"
			:total-rows="pagination.rows"
			:per-page="pagination.perPage"
			last-number
			align="fill"
			limit="11"
		></b-pagination>
		<FlashMessage :position="'right bottom'"></FlashMessage>
	</div>
</template>

<script>
import Navbar from '../components/Navbar';
import VueContext from 'vue-context';

export default {
	name: 'Home',
	components: {
		Navbar,
		VueContext
	},
	data() {
		return {
			pagination: {
				rows: 100,
				perPage: 9,
				currentPage: 1
			},
			profileData: {
				profiles: null,
				last_page: null,
				total: null
			}
		}
	},
	mounted() {
		this.showSuccess();
		this.loadData(this.currentPage);
	},
	methods: {
		deleteProfile(title, id) {
			let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

			this.$confirm(
				{
					title: 'Confirm',
					message: `Are you sure? Want to delete this password profile permanently`,
					button: {
						no: 'Cancel',
						yes: 'Delete'
					},

					callback: confirm => {
						if (confirm) {
							axios.delete(`/api/passwords/${id}`, {
								headers: {
									"Authorization": `Bearer ${token}`
								}
							})
							.then(res => {
								console.log(res);
								if (res.data.success) {
									this.flashMessage.setStrategy('multiple');
									this.flashMessage.info({
										title: 'Profile Deleted Successfully',
										message: `You Successfully Deleted ${title}`,
										icon: '/img/icons/info.svg',
									});
									this.loadData(this.currentPage);
								} else {
									this.flashMessage.setStrategy('multiple');
									this.flashMessage.error({
										title: 'Profile Cannot Be Deleted',
										message: `You Cannot Delete ${title}`,
										icon: '/img/icons/error.svg',
									});
								}
							}).catch(error => console.log(error));
						}
					}
				}
			)
		},
		showSuccess() {
			let successMSG = JSON.parse(window.localStorage.getItem('successMSG'));

			if (successMSG != null) {
				this.flashMessage.setStrategy('multiple');
				this.flashMessage.success({
					title: successMSG.title,
					message: successMSG.message,
					icon: '/img/icons/success.svg',
				});

				window.localStorage.removeItem('successMSG');
			}
		},
		loadData(page) {
			let token = JSON.parse(window.localStorage.getItem('authUser')).access_token;

			axios.get(`/api/passwords?page=${page}`, {
				headers: {
					"Authorization": `Bearer ${token}`
				}
			})
			.then(res => {
				this.pagination.rows = res.data.total;
				this.profileData.last_page = res.data.last_page;
				this.profileData.profiles = res.data.data;
			})
			.catch(error => {
				console.log(error);
			})
		}
	},
	watch: {
		"pagination.currentPage"(val) {
			this.loadData(val);
		}
	}
}
</script>

<style lang="scss">
	@import '~vue-context/dist/css/vue-context.css';
	@import '/scss/home.scss';
</style>