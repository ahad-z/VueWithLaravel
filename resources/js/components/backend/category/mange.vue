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
                                <div class="header-counter">
                                    {{ selected.length }}
                                </div>
                            <table class="table table-sm">
                                <thead>
                                <tr>

                                    <th>
                                        <input :disabled="afterEmptyDataAction()" type="checkbox" @click="selectAll" v-model="selectedAll">
                                    </th>
                                    <th style="width: 10px">#</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category,index) in getCategories">
                                    <td><input type="checkbox" :value="category.id"   v-model="selected"></td>
                                    <td>{{ index+1 }}</td>
                                    <td>{{ category.category_name  }}</td>
                                    <td><span class="badge" :class="statusColor(category.status)">{{ statusName(category.status) }}</span>  </td>
                                    <td>{{ category.created_at | time }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="`/edit-category/${category.category_slug}`" class="btn btn-info btn-sm">Edit</router-link>
                                            <button @click="removeCategory(category.category_slug);" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div class="dropdown">
                                            <button :disabled="!isSelected" v-if=" getCategories.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button  class="dropdown-item" @click="removesData(selected)" href="#">Action</button>
                                                <button  class="dropdown-item" @click="changeStatus(selected)" href="#">Change Status</button>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr v-if="afterEmptyDataAction()">
                                    <td colspan="6" style="color: red;text-align: center"> <h4>No record available</h4></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            selected:[],
            isSelected:false,
            selectedAll:false

        }
    },
    computed:{
        getCategories(){
            return this.$store.getters.categories;
        }

    },
    mounted() {

        this.$store.dispatch("getCategories");
    },
    watch:{
        selected : function (data){
            this.isSelected = (data.length > 0)
            this.selectedAll = (data.length === this.getCategories.length )
        },

    },
    methods:{
        statusName:function(status){
           let  data= {0:"Inactive", 1:"Active"}
           return data[status]
        },
        statusColor:function(status){
            let Class = {0: "badge-danger", 1: "badge-success"}
            return Class[status]
       },
        removeCategory:function(categorySlug){
            this.confirm(() => {
                this.$store.dispatch('removeCategories',categorySlug )
                /*axios.get('category-delete/' +categorySlug).then(response => {
                        this.$store.dispatch("getCategories");
                    })*/
            });


        },
        afterEmptyDataAction:function (){
            return this.getCategories.length < 1;
            // longest way
            /*if(this.getCategories.length< 1){
                return  true
            }else{
                return  false
            }*/
        },
        selectAll: function (event){
            if(event.target.checked === false){
              this.selected = [];
            }else{
                this.getCategories.forEach((category) => {
                   this.selected.push(category.id)
                })
            }
        },
        removesData : function(data){
            const FatherThis = this
            axios.post("/categories/removes-items", {selectedId:data}).then((response) => {
                this.multipleCheck()
                toastr.success(response.data.total + ' Category has been delete successfully')
            }).catch((error) => {
                console.log(error)

            })
        },
        changeStatus: function(data){
            axios.post('/categories/change-status',{selectedId:data}).then((response) => {
                this.multipleCheck()
                toastr.success(response.data.total + ' Status has been Updated successfully')
            }).catch((error) => {
                console.log(error)
            })
        }
    }
}

</script>

<style scoped>

.table thead th {
    font-weight: 800;
    color: rgb(89 117 22);
    font-size: 0.75rem;
    text-transform: uppercase;
}
 .header-counter {
     border: 1px solid #dcbaba;
     font-size: 18px;
     margin: 13px;
     width: 25px;
     text-align: center;
 }

</style>
