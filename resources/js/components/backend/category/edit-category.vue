<template>
    <div>
        <section class="content pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Edit Your Category</h3>
                                <router-link to="/categories" class="btn btn-primary btn-sm" style="float: right" type="submit">All category</router-link>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <form class="form-horizontal" @submit.prevent="updateCategory">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="category" class="col-sm-2 col-form-label">Update Your Category</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('category_name') }" id="category" placeholder="Enter Your Category..." v-model="form.category_name" name="category_name">
                                                <has-error :form="form" field="category_name"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group-row">
                                            <label for="category" class="col-sm-2 col-form-label">Status</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" value="1" v-model="form.status" name="status">
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" value="0" v-model="form.status" name="status">
                                                <label class="form-check-label" for="inactive">Inactive</label>
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
export default {
name: "edit-category",
    data: function () {
        return {
            form: new Form({
                category_name: null,
                status:null
            })
        }
    },

    mounted() {
    this.getCategory()
    },
    methods:{
        updateCategory:function (){
            let FatherThis = this
            this.form.post("/category-update/" + this.$route.params.slug).then(response => {
                Toast.fire({
                    icon: 'success',
                    title: 'Category updated  successfully'
                })
                FatherThis.$router.push('/categories');

            })
        },
        getCategory:function(){
            let FatherThis = this
            axios.get("/category-show/" + this.$route.params.slug ).then(response => {
                FatherThis.form.fill(response.data.category)
            })
        }
    }
}
</script>

<style scoped>

</style>
