<template>
    <div>
        <!-- Main content -->
        <section class="content pt-4">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">All Category</h3>
                            <router-link to="/add-category" class="btn btn-primary btn-sm" style="float: right" type="submit">Add category</router-link>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category, i) in allCategories">
                                    <td>{{ i+1 }}</td>
                                    <td>{{ category.category_name }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info btn-sm">Edit</a>
                                            <button onclick="return confirm('Are u sure!')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ something }}
                </div>
            </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

</template>

<script>
export default {
    name: "mange.vue",
    data(){
        return {
            allCategories:[]
        }
    },
    computed:{
        something(){
            return this.$store.getters.test;
        }
    },
    mounted() {
        this.getAllCategory();
    },
    methods:{
        getAllCategory:function (){
            axios.get('/category').then(response => {
                this.allCategories = response.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
