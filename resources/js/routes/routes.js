import home from "../components/backend/home";
/* For Categories*/
import categories from "../components/backend/category/mange";
import addCategories from "../components/backend/category/add-category";
export const routes = [

    { path: '/home', component: home },
    { path: '/categories', component: categories },
    { path: '/add-category', component: addCategories },

]
