<template>
    <vue-custom-scrollbar class="sidebar" :settings="settings" @ps-scroll-y="scrollHanle">
        <h1 class="title">Master Key</h1>
        <SidebarItem :selected="true" link="/admin/">Dashboard</SidebarItem>
        <SidebarItemGroup v-for="n in 4" :key="n" title="Users">
            <SidebarItem link="/admin/users">Users List</SidebarItem>
            <SidebarItem link="/admin/users/add">Add User</SidebarItem>
            <SidebarItem link="/admin/users/edit">Edit User</SidebarItem>
            <SidebarItem link="/admin/users/delete">Delete User</SidebarItem>
        </SidebarItemGroup>
    </vue-custom-scrollbar>
</template>

<script>
import SidebarItem from '../assets/SidebarItem.vue';
import SidebarItemGroup from '../assets/SidebarItemGroup.vue';
import vueCustomScrollbar from 'vue-custom-scrollbar'
import "vue-custom-scrollbar/dist/vueScrollbar.css"

export default {
    components: {
        SidebarItem,
        SidebarItemGroup,
        vueCustomScrollbar
    },
    data() {
        return {
            settings: {
                suppressScrollY: false,
                suppressScrollX: true,
                wheelPropagation: false
            }
        }
    },
    methods: {
        scrollHanle(evt) {
            console.log(evt)
        }
    }
}
</script>

<style lang="scss" scoped>
.sidebar {
    background: #3C4B64;
    height: 100vh;
    width: 256px;
    z-index: 1;
    color: #fff;
    float: left;
    position: relative;

    .title {
        text-align: center;
        font-size: 35px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
}
</style>