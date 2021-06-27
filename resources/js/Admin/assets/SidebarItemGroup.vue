<template>
    <div class="item-group">
        <h3>{{ title }}</h3>
        <div class="body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: 'Title'
        }
    }
}
</script>

<style lang="scss" scoped>
h3 {
    padding: 7px 16px;
}
</style>