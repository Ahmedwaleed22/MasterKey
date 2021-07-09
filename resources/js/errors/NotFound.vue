<template>
    <div class="notfound">
        <span class="logo">!</span>
        <div class="text">
            <h1>Page Not Found</h1>
            <p>Go To <a href="/">Home Page</a></p>
        </div>
    </div>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
$border-color: #dc3545;
.notfound {
    text-align: center;
    margin-top: 10rem;

    .logo {
        font-size: 100px;
        border: 10px solid $border-color;
        padding: 20px 65px;
        border-radius: 50%;
        margin-bottom: 100px;
    }
    .text {
        margin-top: 30px;
    }
}
</style>