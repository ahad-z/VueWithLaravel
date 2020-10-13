<template>
    <div>
        <div class="blog-post  wow fadeInUp" v-for="post in publishedPosts.data">
            <a href="blog-details.html"><img class="img-responsive" :src="fileLink(post.thumbnail)" alt=""></a>
            <h1><a href="blog-details.html">{{ post.title }}</a></h1>
            <span class="author">{{ post.user.name }}</span>
            <span class="review">6 Comments</span>
            <span class="date-time">{{ post.created_at | time }}</span>
            <p>{{ htmlTagRemover(post.content) | shortContent(50,'...')  }}</p>
            <router-link :to="`/post/${post.post_slug}`"  class="btn btn-upper btn-primary read-more">read more</router-link>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "Home",
    data(){
        return {}
    },
    computed:{
        ...mapGetters({
            publishedPosts: 'posts',
            categories : 'categories',
            paginateCategory: 'paginateCategory'
        })
    },
    mounted(){
        this.$store.dispatch("getAllPosts")
    }
}
</script>

<style scoped>

</style>
