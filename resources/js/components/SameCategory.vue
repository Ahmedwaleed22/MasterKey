<template>
    <section id="same-category">
        <h1 class="title" v-html="title"></h1>
		<b-container>
			<div id="password-profiles">
				<div class="profile" v-for="(profile, n) in profiles" :key="n">
					<img :src="profile.app.logo" />
					<h3>Facebook</h3>
					<p class="description">Social Media Platform</p>
					<a :href="`/showpassword/${profile.id}`" class="show-password">
						<font-awesome-icon icon="key" />
					</a>
				</div>
			</div>
		</b-container>
    </section>
</template>

<script>
export default {
    name: 'SameCatgeory',
    props: {
        title: {
            default: 'From Same <span style="color: red">Category</span>',
            type: String
        },
        profiles: Array
    }
}
</script>

<style lang="scss" scoped>
$borderColor: #333;
$primary-color: red;
$secondary-color: #ff4b4b;

.title {
    text-align: center;
}
#same-category {
    padding-bottom: 20px;
}
#password-profiles {
    display: grid;
    grid-template-columns: auto auto auto;
    margin-top: 30px;
    justify-content: center;
    grid-template-columns: repeat(auto-fit, minmax(300px, 340px));

    .profile {
        border: 1px solid $borderColor;
        margin: 5px;
        height: 170px;
        max-width: 340px;
        min-width: 280.36px;
        padding: 10px;
        position: relative;

        img {
            height: 50px;
            width: 50px;
            margin-bottom: 10px;
        }
        .show-password {
            background: $secondary-color;
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            right: 0;
            bottom: 0;
            margin-bottom: 10px;
            margin-right: 10px;
            cursor: pointer;
            transition-duration: 0.6s;
            transition-property: transform;
            
            &:hover {
                transform: rotate(408deg);
            }
        }
    }
}
</style>