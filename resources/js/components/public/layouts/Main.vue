<template>
    <div class="blog-page my-3">
        <div class="col-md-9">
            <router-view></router-view>
        </div>
        <div class="col-md-3 sidebar">
            <SideBar/>
        </div>
    </div>
</template>
<script>
import  SideBar from "./partials/Sidebar"
export default {
    name: "Main",
    components:{
        SideBar
    }
}
</script>

<style scoped>

</style>
