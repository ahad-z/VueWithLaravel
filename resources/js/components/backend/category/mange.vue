<template>
    <div>
        <section class="content pt-4">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">All Category</h3>
                            <router-link to="/add-category" class="btn btn-primary btn-sm" style="float: right" type="submit">Add category</router-link>
                            <div class="form-inline ml-3" style="float: right;margin-right: 10px;">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchKey" @keyup="searchContent()">
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                                <div class="header-counter">
                                    {{ selected.length }}
                                </div>
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>
                                        <input :disabled="getCategories.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
                                    </th>
                                    <th style="width: 10px">#</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category,index) in getCategories.data">
                                    <td><input type="checkbox" :value="category.id" v-model="selected"></td>
                                    <td>{{ category.id }}</td>
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
                                            <button :disabled="!isSelected" v-if="getCategories.data && getCategories.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button  class="dropdown-item" @click="batchDelete(selected)" href="#">DELETE</button>
                                                <button  class="dropdown-item" @click="changeStatus(selected)" href="#">Change Status</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="getCategories.data == 0">
                                    <td colspan="6" style="color: red;text-align: center"><h4>No record available</h4></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <pagination :data="getCategories" @pagination-change-page="paginate"></pagination>
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
    name: "mange.vue",
    data(){
        return {
            selected:[],
            isSelected:false,
            selectedAll:false,
            searchKey:'',
            page: 1
        }
    },
    computed:{
        getCategories(){
            return this.$store.getters.categories;
        }
    },
    mounted() {
        this.$store.dispatch("getCategories");

        Fire.$on('searching', (data) => {
            this.searchKey = data;
            this.paginate();
        })
    },
    watch:{
        selected : function (data){
            this.isSelected = (data.length > 0)
            this.selectedAll = (data.length === this.getCategories.data.length )
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
                this.$store.dispatch('removeCategories', categorySlug)
            });
        },
        selectAll: function (event){
            if(event.target.checked === false){
              this.selected = [];
            }else{
                this.getCategories.data.forEach((category) => {
                   this.selected.push(category.id)
                })
            }
        },
        batchDelete : function(selectedId){
            const FatherThis = this;
            axios.post("/categories/removes-items", { selectedId }).then((response) => {
                this.multipleCheck()
                this.$store.dispatch("getCategories", { page: this.page });
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
        },

        searchContent: _.debounce( function (){
            this.$store.dispatch("getCategories", { search_query: this.searchKey })
        }, 300),

        paginate: function(page = 1) {
            this.page = page;
            this.$store.dispatch("getCategories", { page: this.page, search_query: this.searchKey })
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
