<template>
    <div class="suggestion" id="suggestion-body">
        <p class="text">{{ suggestion }}</p>
        <span class="name">By: {{ username }}</span>
        <span class="date">{{ date }}</span>
    </div>
</template>

<script>
export default {
    name: 'Suggestion',
    props: {
        suggestion: String,
        username: String,
        date: String
    }
}
</script>

<style lang="scss" scoped>
.suggestion {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    background: #f5f5f5;
    padding: 15px;
    color: #333;
    border-radius: 15px;

    .text {
        width: 100%;
        margin-bottom: 10px;
    }
    .name {
        width: 100%;
        text-align: right;
    }
    .date {
        width: 100%;
        text-align: right;
    }

    &:not(:last-child) {
        margin-bottom: 20px;
    }
}
</style>