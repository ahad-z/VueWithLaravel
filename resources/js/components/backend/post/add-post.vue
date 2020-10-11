<template>
    <div>
        <section class="content pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Add Your Post</h3>
                                <router-link to="/posts" class="btn btn-primary btn-sm" style="float: right">Manage Post</router-link>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="addPost">
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
                                                <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="thumbnail"   class="col-sm-2 col-form-label">Content</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="thumbnail"  id="thumbnail" @change="lodeImg($event)">
                                                <img :class="{imgHeight :form.thumbnail}"  :src="form.thumbnail" alt="">

                                            </div>
                                        </div>
                                        <div class="form-group-row">
                                            <label  class="col-sm-2 col-form-label">Status</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" value="published" v-model="form.status" name="status">
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" value="draft" v-model="form.status" name="status">
                                                <label class="form-check-label" for="inactive">Inactive</label>
                                            </div>
                                            <span :class="{ 'is-invalid': form.errors.has('status') }"></span>
                                            <has-error :form="form" field="status"></has-error>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button  :disabled="form.busy" class="btn btn-info">Add Post</button>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    name: "add-post",
    data: function () {
        return {
            form: new Form({
                title: null,
                status: null,
                description:null,
                category_id: '',
                thumbnail:null
            }),
            editor: ClassicEditor,
            editorData: '<p>Content of the editor.</p>',
            editorConfig: {
                // The configuration of the editor.
            }
        }
    },

    mounted() {
        this.$store.dispatch("getActiveCategories");
    },
    computed: {
        getCategories() {
            return this.$store.getters.categories;
        }
    },
    methods: {
        addPost: function () {
            const FatherThis = this
            this.form.post('/post').then((response) => {
                if(response.data.status){
                    Toast.fire({
                        icon: 'success',
                        title: 'Post submitted in successfully'
                    })
                    FatherThis.form.title = null
                    FatherThis.form.status = null
                    FatherThis.form.category_id = null
                    FatherThis.form.thumbnail = null
                }
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
