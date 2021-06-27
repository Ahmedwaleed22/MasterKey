<template>
    <div v-if="is_admin">
        <Sidebar />
        <div class="panel-body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Sidebar from './Sidebar.vue';

export default {
    components: {
        Sidebar
    },
    data() {
        return {
            is_admin: false
        }
    },
    mounted() {
        this.adminCheck();
    },
    methods: {
        adminCheck() {
            const authUser = JSON.parse(window.localStorage.getItem('authUser'));

            axios.get('/api/auth/user-profile', {
                headers: {
                    'Authorization': `Bearer ${authUser.access_token}`
                }
            }).then(res => {
                if (res.data.is_staff || res.data.is_admin) {
                    this.is_admin = true;
                } else {
                    this.$router.push('/');
                }
            }).catch(err => {
                this.$router.push('/');
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.panel-body {
    float: left;
}
</style>