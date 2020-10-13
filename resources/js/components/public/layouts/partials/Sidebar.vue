<template>
    <div class="sidebar-module-container">
        <div class="sidebar-widget outer-bottom-xs wow fadeInUp">
            <h3 class="section-title">Category</h3>
            <div class="sidebar-widget-body m-t-10">
                <div class="accordion">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a href="#collapseOne" data-toggle="collapse" class="accordion-toggle collapsed" v-for="category in categories">
                                {{ category.category_name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from  'vuex';
export default {
    name: "SideBar",
    computed:{
       ...mapGetters({
           categories:'categories'
       })
    },
    mounted() {
        this.$store.dispatch("getActiveCategories");

        Fire.$on('searching', (data) => {
            this.searchKey = data;
            this.paginate();
        })
    },
}
</script>

<style scoped>

</style>
