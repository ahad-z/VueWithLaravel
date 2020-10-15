<template>
<div>
    <div class="blog-post  wow fadeInUp" v-if="post">
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
            <form @submit.prevent="addComment">
                <input name="post_id" type="hidden" value="post.id">
                <textarea rows="4" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('body') }" name="body" spellcheck="true" v-model="form.body"></textarea>
                <has-error :form="form" field="body"></has-error>
                <button type="submit"  :disabled="form.busy" style="margin-top: 5px" class="btn btn-primary btn-sm">Add Comment</button>
            </form>
        </div>
    </div>
    <br>

<div class="card" v-for ="vote in post.votes">
  <div class="card-header">
    Comments
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p>{{ vote.body }}</p>
      <footer class="blockquote-footer">{{ vote.created_at | time  }}  <cite title="Source Title">By Unknown</cite></footer>
    </blockquote>
  </div>
</div>

    <!-- <div class="mb-5" v-for ="vote in post.votes">
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between">
                <div class="mr-2 text-dark">
                    Ahad
                    <div class="text-xs text-muted">{{ vote.created_at | time  }}</div>
                </div>
            </div>
            <div class="card-body">
                {{ vote.body }}
            </div>
        </div>
    </div> -->
</div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    name: "Singlepostview",
    data: function () {
        return {
            form: new Form({
                body: null,


            }),
            post: null
        }
    },
    computed:{

    },
    methods:{
        addComment: function() {
            const currentThis = this;
            this.form.post_id = this.post.id;
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
                        title: response.data.message
                    })
                }

            })
        }
    },
    mounted(){
        axios.get(`/post/show/${this.$route.params.slug}`).then(response => {
            this.post = response.data.post;
            console.log(response.data)
        }).catch((error) => {
            console.log(error)
        })
    }

}
</script>

<style scoped>

</style>
