<template>
    <div>
        <section class="content pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Edit Your Post</h3>
                                <router-link to="/posts" class="btn btn-primary btn-sm" style="float: right" type="submit">All Post</router-link>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <form class="form-horizontal" @submit.prevent="updatePost">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10 ">
                                                <select id="category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }"  v-model="form.category_id">
                                                    <option value="">---Select Category--</option>
                                                    <option :value="cat.id" v-for="cat in getCategories">{{ cat.category_name }}</option>
                                                </select>
                                                <has-error :form="form" field="category_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }" id="title" placeholder="Enter Your title..." v-model="form.title" name="title">
                                                <has-error :form="form" field="title"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Content</label>
                                            <div class="col-sm-10">
                                                <ckeditor :editor="editor" v-model="form.content" :config="editorConfig"></ckeditor>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="thumbnail"  class="col-sm-2 col-form-label">Content</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="thumbnail"  id="thumbnail" @change="lodeImg($event)">
                                                <img :class="{imgHeight :form.thumbnail}"  :src="fileLink(form.thumbnail)" alt="">
                                                   <!-- <img :class="{imgHeight :form.thumbnail}"  :src="thumbURL" alt="">  -->
                                            </div>
                                        </div>
                                        <div class="form-group-row">
                                            <label for="category" class="col-sm-2 col-form-label">Status</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" value="published" v-model="form.status" name="status">
                                                <label class="form-check-label badge badge-success" for="active">Published</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" value="draft" v-model="form.status" name="status">
                                                <label class="form-check-label  badge badge-danger" for="inactive">Draft</label>
                                            </div>
                                            <span :class="{ 'is-invalid': form.errors.has('status') }"></span>
                                            <has-error :form="form" field="status"></has-error>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" :disabled="form.busy" class="btn btn-info">Update</button>
                                        <button type="reset" class="btn btn-default float-right">Reset</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
name: "edit-post",
    data: function () {
        return {
            form: new Form({
                id:null,
                title: null,
                status: null,
                content:null,
                category_id: '',
                thumbnail:null
            }),
            editor: ClassicEditor,
            editorConfig: {}
        }
    },

    mounted() {
        this.getCategories;
        this.getPost();
        this.$store.dispatch("getActiveCategories");
    },
    computed: {
        getCategories() {
            return this.$store.getters.categories;
        },
       /* thumbURL() {
            return window.location.protocol +'//'+ window.location.host + '/uploads/post/' +this.form.thumbnail;
        }*/
    },
    methods:{
        updatePost:function (){
            this.form.put("/post/" + this.$route.params.slug ).then((response) => {
                if(response.data.status){
                    toastr.success('Post Updated successfully!')
                     this.$router.push('/posts')
                }else{
                    toastr.warning(response.data.message)
                }
            })

        },
        getPost: function(){
            axios.get("/post/show/"+ this.$route.params.slug  ).then((response) => {
                this.form.fill(response.data.post)
            })
        }
    }
}
</script>

<style scoped>
.imgHeight {
    border: 1px solid #ddd; /* Gray border */
    border-radius: 4px;  /* Rounded border */
    padding: 5px; /* Some padding */
    width: 150px; /* Set a small width */
}
img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
