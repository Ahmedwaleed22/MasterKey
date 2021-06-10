<template></template>

<script>
import axios from 'axios';

export default {
    name: 'Logout',

    mounted() {
        axios.post('/api/auth/logout', {}, {
            headers: {
                "Authorization": "Bearer " + window.localStorage.getItem("authUser"),
            }
        })
        .then(res => {
            window.localStorage.removeItem("authUser");
        })
        .catch(error => {
            console.log(error);
        })
        .finally(() => {
            window.location.replace("/login");
        });
    }
}
</script>