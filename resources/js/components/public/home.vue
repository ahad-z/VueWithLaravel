<template>
    <div>
        <div class="blog-post  wow fadeInUp" v-for="post in publishedPosts.data">
            <a href="blog-details.html"><img class="img-responsive" :src="fileLink(post.thumbnail)" alt=""></a>
            <h1><a href="blog-details.html">{{ post.title }}</a></h1>
            <span class="author">{{ post.user.name }}</span>
            <span class="review">{{ post.votes.length }}</span>
            <span class="date-time">{{ post.created_at | time }}</span>
            <p>{{ htmlTagRemover(post.content) | shortContent(50,'...')  }}</p>
            <router-link :to="`/post/${post.post_slug}`"  class="btn btn-upper btn-primary read-more">read more</router-link>
        </div>
        <div>
        <pagination :data="publishedPosts" @pagination-change-page="paginate"></pagination>
        </div>
        <h5 class="alert alert-danger text-center" v-if="publishedPosts.data == 0">No Record available</h5>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "Home",
    data(){
        return {
            page:1
        }
    },
    computed:{
        ...mapGetters({
            publishedPosts: 'posts',
            categories : 'categories',
            paginateCategory: 'paginateCategory'
        })
    },
    methods:{

        paginate: function(page = 1) {
            this.page = page;
            this.$store.dispatch("getAllPosts", {page:this.page})
        }

    },
    mounted(){
        
        this.$store.dispatch("getAllPosts")
    }
}
</script>

<style scoped>

</style>
