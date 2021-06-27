import axios from 'axios';

function logout() {
    axios.post('/api/auth/logout', {}, {
        headers: {
            "Authorization": "Bearer " + JSON.parse(window.localStorage.getItem("authUser")).access_token,
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

export default logout;