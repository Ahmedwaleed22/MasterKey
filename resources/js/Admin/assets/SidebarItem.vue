<template>
    <router-link :to="link">
        <div :class="(selected) ? 'selected' : ''" class="item">
            <span class="title">
                <slot></slot>
            </span>
        </div>
    </router-link>
</template>

<script>
export default {
    props: {
        link: {
            type: String,
            default: '/'
        },
        selected: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
$main-color: #ff4b4b;

a {
    color: hsla(0,0%,100%,.8);
    text-decoration: none;

    .item.selected {
        color: #fff;
        background: hsla(0,0%,100%,.05);
    }
    .item {
        padding: 13.5px 16px;
        cursor: pointer;
        transition: background 0.3s;

        &:hover {
            background: $main-color;
        }
    }

    &:hover {
        color: #fff;
        text-decoration: none;
    }
}
</style>