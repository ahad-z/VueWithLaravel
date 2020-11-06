    export default {
    state: {
        categoryData: {},
        paginateCategory:{},
        postData:{}
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
                state.postData = state.postData.data.filter(function(item) {
                    return item.post_slug !== data.postslug;
                })
                toastr.success('Post deleted successfully.')
            }else {
                toastr.warning(data.response.message)
            }
        },
        catchDeleteCategory(state,data){
            if(data.response.status){
                state.categoryData = state.categoryData.data.filter(item => item.category_slug !== data.categorySlug)
                toastr.success('Category deleted successfully.')
            }else{
                toastr.warning(data.message)
            }
        },
        catchCategorySearchData(state, category){
            state.categoryData = category
        },
        catchCategoryPaginate(state,data){
            state.paginateCategory = data
        }
    },
    actions:{
        getCategories(context, data = null){
            let queryParams = '';
            if (data) {
                queryParams = `?${ $.param(data) }`;
            }

            axios.get(`/category${ queryParams }`).then(response => {
               context.commit("catchCategories", response.data)
            }).catch((error) =>{
                console.log(error)
            })
        },
        getActiveCategories(context){
            axios.get('/category/active-category').then(response => {
                context.commit('catchCategories', response.data.allActiveCategory)
            }).catch((error) => {
                console.log(error)
            })
        },
        getTopCategories(context){
            axios.get('/category/active-top-category').then(response => {
                context.commit('catchCategories', response.data.data)
            }).catch((error) => {
                console.log(error)
            })
        },
        getPosts (context,data = null){
            let queryParams = '';
            if(data){
                queryParams = `?${ $.param(data) }`;
            }
            axios.get(`/post${queryParams}`).then(response => {
                context.commit('catchPosts', response.data)
            }).catch((error) => {
                console.log(error)
            })
        },
        getAllPosts(context, page){

           let queryParams = `?${ $.param(page) }`

            axios.get(`/post${queryParams}`).then(response => {
                context.commit('catchPosts', response.data)
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
                context.commit('catchCategories', {response: response.data, categorySlug})
            }).catch((error) => {
                console.log(error)
            })
        },
        algoliaSearchAction(context,searchKey){

            axios.get('/post/algosearch/'+ searchKey).then( response => {
                context.commit('catchPosts', response.data)
            })
        }
    },
    getters:{
        categories (state) {
            return state.categoryData
        },
        posts (state) {
            return state.postData
        },
        paginateCategory(state){
            return state.paginateCategory
        }
    }
}

