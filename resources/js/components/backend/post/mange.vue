<template>
    <div>
        <!-- Main content -->
        <section class="content pt-4">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">All Post</h3>
                            <router-link to="/add-posts" class="btn btn-primary btn-sm" style="float: right" type="submit">Add Post</router-link>
                            <div class="form-inline ml-3" style="float: right;margin-right: 10px;">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchKey" @keyup="searchContent()">
                                </div>
                            </div>
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
                                        <input type="checkbox" :disabled="Posts.data == 0" @click="selectAll" v-model="selectedAll">
                                    </th>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Post Title</th>
                                    <th>Post Content</th>
                                    <th>Thumb</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(post , index) in Posts.data">
                                    <td><input type="checkbox" :value="post.id" v-model="selected"></td>
                                    <td>{{ index+1 }}</td>
                                    <td>{{ post.category.category_name }}</td>
                                    <td>{{ post.title | shortContent(20, '......') }}</td>
                                    <td v-html="post.content"></td>
                                    <td> <img width="100px"  :src="fileLink(post.thumbnail)" alt="img"></td>
                                    <td><span class="badge" :class="setColor(post.status)" >{{ post.status | capitalize }} </span></td>
                                    <td>{{ post.created_at |time }}</td>
                                    <td>{{ post.user.name  }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="`/posts-edit/${post.post_slug}`" class="btn btn-info btn-sm">Edit</router-link>
                                            <button @click="deletePost(post.post_slug)"  type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9">
                                        <div class="dropdown">
                                            <button :disabled="!isSelected" v-if=" Posts.data && Posts.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button  class="dropdown-item" @click="removePosts(selected)"  href="#">DeleteAll</button>
                                                <button  class="dropdown-item" @click="changeStatus(selected)"  href="#">Change Status</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="color: red;text-align: center" v-if="Posts.data == 0"> <h4>No record available</h4></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <pagination :data="Posts" @pagination-change-page="paginate"></pagination>
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
    data() {
        return{
            selected:[],
            selectedAll:false,
            isSelected :false,
            page:1,
            searchKey:''

        }
    },
    watch:{
        selected:function(data){
            this.isSelected = (data.length > 0)
            this.selectedAll = (data.length === this.Posts.length)
        }
    },
    computed:{
      Posts () {
          return this.$store.getters.posts
      }
    },
    methods:{
        setColor:function(status){
            let data = {published : 'badge-success', draft:'badge-danger'}
            return data[status]
        },
        deletePost(postslug) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("removePost", postslug);
                }
            })
        },
        /*afterEmptyData(post){
           return  Object.keys(post).length === 0
        },*/
        selectAll:function(event){
            if(event.target.checked === false){
                this.selected = []
            }else{
                this.Posts.data.forEach((post) => {
                    this.selected.push(post.id)
                })
            }
        },
        removePosts: function(data){
            this.confirm(() => {
                axios.post('/post/remove-posts',{selectedID :data}).then((response) => {
                   if(response.data.status){
                       this.multipleCheck()
                       this.$store.dispatch("getPosts");
                       toastr.success(response.data.total + ' '+ response.data.message)
                   }else {
                       toastr.warning(response.data.message)
                   }
                }).catch((error) => {
                    console.log(error)
                })
            })
        },
        changeStatus : function(data){
            axios.post('/post/status-change', {selectedId:data}).then((response) => {
                if(response.data.status){
                    this.multipleCheck()
                    this.$store.dispatch("getPosts")
                    toastr.success(response.data.total + ' Post status has been updated')

                }else{
                    toastr.warning(response.data.message)
                }
            }).catch((error) => {
                console.log(error)
            })
        },
        searchContent: _.debounce( function (){
            this.$store.dispatch("getPosts", { search_query: this.searchKey })
        }, 300),
        paginate: function(page = 1) {
                this.page = page;
                this.$store.dispatch("getPosts", { page: this.page, search_query: this.searchKey })
            }
    },
    mounted(){
        this.paginate();
        this.$store.dispatch("getPosts")
        Fire.$on('searching', (data) => {
            this.searchKey = data;
            this.paginate();
        })
    }
}
</script>

<style scoped>

.header-counter {
    border: 1px solid #dcbaba;
    font-size: 18px;
    margin: 13px;
    width: 25px;
    text-align: center;
}
</style>
