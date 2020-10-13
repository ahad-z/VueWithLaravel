<template>
    <div>
        <div class="blog-post  wow fadeInUp" v-for="post in categoryBasePost.data">
            <a href="blog-details.html"><img class="img-responsive" :src="fileLink(post.thumbnail)" alt=""></a>
            <h1><a href="blog-details.html">{{ post.title }}</a></h1>
            <span class="author">{{ post.user.name }}</span>
            <span class="review">6 Comments</span>
            <span class="date-time">{{ post.created_at | time }}</span>
            <p v-html="post.content"></p>
            <a href="#" class="btn btn-upper btn-primary read-more">read more</a>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    name: "CategoryPost",
    computed:{
        ...mapGetters({
            categoryBasePost : 'posts'
        })
    },
    mounted(){
        this.$store.dispatch("getPosts", { slug: this.$route.params.slug } )
    }

}
</script>


<style scoped>

</style>
