<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="danger">
            <b-navbar-brand to="/">MasterKey</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-navbar-nav>
                        <b-nav-item to="/createprofile">Create Password Profile</b-nav-item>
                        <b-nav-item to="/suggestions">Suggestions</b-nav-item>
                        <b-nav-item to="/pricing">Pricing</b-nav-item>
                        <b-nav-item to="/contact">Contact Us</b-nav-item>
                    </b-navbar-nav>

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template #button-content>
                            <span v-if="loaded">{{ userdata.username }}</span>
                        </template>
                        <b-dropdown-item to="/logout">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item v-if="!dark_mode" @click="changeTheme()" href="#"><font-awesome-icon icon="moon" /></b-nav-item>
                    <b-nav-item v-else @click="changeTheme()" href="#"><font-awesome-icon icon="sun" /></b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userdata: null,
            loaded: false,
            dark_mode: false,
        }
    },
    mounted() {
        this.userdata = JSON.parse(window.localStorage.getItem('authUser')).user;
        this.loaded = true;

        this.getTheme();
    },
    methods: {
        changeTheme() {
            if (window.localStorage.getItem('darkmode')) {
                window.localStorage.removeItem('darkmode');
                this.dark_mode = false;
                document.getElementById('app').removeAttribute('class', 'dark-mode');
            } else {
                window.localStorage.setItem('darkmode', true);
                this.dark_mode = true;
                document.getElementById('app').setAttribute('class', 'dark-mode');
            }
        },
        getTheme() {
            if (window.localStorage.getItem('darkmode')) {
                this.dark_mode = true;
                document.getElementById('app').setAttribute('class', 'dark-mode');
            } else {
                this.dark_mode = false;
                document.getElementById('app').removeAttribute('class', 'dark-mode');
            }
        }
    }
}
</script>

<style lang="scss">
$main-color: #ff4b4b;

.dropdown-toggle {
    outline: none !important;
}
</style>