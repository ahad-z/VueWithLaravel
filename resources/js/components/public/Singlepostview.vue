<template>
    <div>
        <div class="blog-post  wow fadeInUp" v-for="post in singlePostDetailes.data">
            <a href="blog-details.html"><img class="img-responsive" :src="fileLink(post.thumbnail)" alt=""></a>
            <h1><a href="blog-details.html">{{ post.title }}</a></h1>
            <span class="author">{{ post.user.name }}</span>
            <span class="review">6 Comments</span>
            <span class="date-time">{{ post.created_at | time }}</span>
            <p v-html="post.content"></p>
        </div>
        <hr>
        <div class="card">
            <div class="card-header">Leave a Comment</div>
            <div class="card-body">

                <form @submit.prevent="addVote">
                    <input type="hidden"  value="1">
                    <textarea rows="4" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('body') }" name="body" spellcheck="true" v-model="form.body"></textarea>
                    <has-error :form="form" field="body"></has-error>
                    <button type="submit"  :disabled="form.busy" style="margin-top: 5px" class="btn btn-primary btn-sm">Add Comment</button>
                </form>

            </div>
        </div>
        <br>
    </div>

</template>
<script>
import {mapGetters} from "vuex";
/*import  Comment from "./Comment";*/

export default {
    name: "Singlepostview",
    data: function () {
        return {
            form: new Form({
                body:null

            })
        }
    },
    /*components: {Comment},
    comments:{
        Comment
    },*/
    computed:{
        ...mapGetters({
            singlePostDetailes : 'posts'
        })
    },
    methods:{
        addVote:function(){
            const currentThis = this;
            this.form.post('/votes').then(response => {
                if(response.data.status){
                    Toast.fire({
                        icon: 'success',
                        title: 'Post submitted in successfully'
                    })
                    currentThis.form.body = null;
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Something went Wrong!'
                    })
                }

            })
        }
    },
    mounted(){
        this.$store.dispatch("getPosts", { slug: this.$route.params.slug })
    }

}
</script>

<style scoped>

</style>
