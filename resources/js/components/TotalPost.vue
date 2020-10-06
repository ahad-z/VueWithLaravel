<template>
    <h1>{{ posts.length }}</h1>
</template>

<script>
export default {
    name: "TotalPost",
    computed: {
        posts() {
            return this.$store.getters.posts
        }
    }
}
</script>

<style scoped>

</style>
