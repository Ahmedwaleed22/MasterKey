<template>
    <div class="Suggestion">
        <h1 class="title" v-html="title"></h1>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'Suggestions',
    props: {
        title: String
    }
}
</script>

<style lang="scss" scoped>
.Suggestion {
    display: flex;
    flex-direction: column;
    max-width: 945px;
    right: 0;
    left: 0;
    margin: auto;

    .title {
        margin-bottom: 30px;
        font-size: 30px;
        text-align: center;
    }
}
</style>