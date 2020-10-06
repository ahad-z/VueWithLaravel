import home from "../components/backend/home";
/* For Categories*/
import categories from "../components/backend/category/mange";
import addCategories from "../components/backend/category/add-category";
import editCategory from "../components/backend/category/edit-category";

/*Post Router*/
import posts from "../components/backend/post/mange";
import addPost from "../components/backend/post/add-post";
import editPost from "../components/backend/post/edit-post";
export const routes = [

    { path: '/home', component: home },
    { path: '/categories', component: categories },
    { path: '/add-category', component: addCategories },
    { path: '/edit-category/:slug', component: editCategory },

    { path: '/posts', component: posts },
    { path: '/add-post', component: addPost },
    { path: '/post-edit/:slug', component: editPost },

]
