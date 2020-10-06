export default {
    state: {
        categoryData:[],
        postData:[]
    },
    mutations: {
        catchCategories(state, data){
            return state.categoryData = data;

        },
        catchPosts(state, data){
            return state.postData = data;
        },
        catchDeletePost(state, data){
            if(data.response.status) {
                // state.postData = state.postData.filter(item => item.id !== data.postID)

                state.postData = state.postData.filter(function(item) {
                    return item.post_slug !== data.postslug;
                })
                toastr.success('Post deleted successfully.')
            }else {
                toastr.warning(data.message)
            }
        },
        catchDeleteCategory(state,data){
            if(data.response.status){
                state.categoryData = state.categoryData.filter(item => item.category_slug !== data.categorySlug)
                toastr.success('Category deleted successfully.')
            }else{
                toastr.warning(data.message)
            }
        }
    },
    actions:{
        getCategories(context){
            axios.get('/category').then(response => {
                context.commit("catchCategories", response.data.categories)
            }).catch((error) =>{
                console.log(error)
            })
        },
        getPosts (context){
            axios.get('/post').then(response => {
                context.commit('catchPosts', response.data.allPosts)
            }).catch((error) => {
                console.log(error)
            })

        },
        removePost(context, postslug){
            axios.delete('/post/' + postslug).then(response => {
                context.commit('catchDeletePost', {response: response.data, postslug})
            }).catch((error) => {
                console.log(error)
            })
        },
        removeCategories(context, categorySlug){
            axios.get('category-delete/' + categorySlug).then(response => {
                context.commit('catchDeleteCategory', {response: response.data, categorySlug})
            }).catch((error) => {
                console.log(error)
            })
        }
    },
    getters:{
        categories (state) {
            return state.categoryData
        },
        posts (state) {
            return state.postData
        }
    },
}

