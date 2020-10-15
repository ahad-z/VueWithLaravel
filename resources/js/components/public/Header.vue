<template>
    <header class="header-style-1">
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    <div class="cnt-account">
                        <ul class="list-unstyled">
                            <li><a href="#"><i class="icon fa fa-lock"></i>Login</a></li>
                        </ul>
                    </div><!-- /.cnt-account -->

                    <div class="clearfix"></div>
                </div><!-- /.header-top-inner -->
            </div><!-- /.container -->
        </div><!-- /.header-top -->
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                        <!-- ============================================================= LOGO ============================================================= -->
                        <div class="logo">
                            <router-link to="/">
                                <img src="images/logo.png" alt="">
                            </router-link>
                        </div><!-- /.logo -->
                        <!-- ============================================================= LOGO : END ============================================================= -->				</div><!-- /.logo-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                        <!-- /.contact-row -->
                        <!-- ============================================================= SEARCH AREA ============================================================= -->
                        <div class="search-area">
                                <div class="control-group">
                                    <input class="search-field" v-model="searchKey" placeholder="Search here..."  @keyup.enter="searchFunc()">
                                    <a class="search-button" href="#" ></a>
                                </div>
                        </div><!-- /.search-area -->
                        <!-- ============================================================= SEARCH AREA : END ============================================================= -->				</div><!-- /.top-search-holder -->

                </div><!-- /.container -->

            </div><!-- /.main-header -->

            <!-- ============================================== NAVBAR ============================================== -->
            <div class="header-nav animate-dropdown">
                <div class="container">
                    <div class="yamm navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="nav-bg-class">
                            <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                                <div class="nav-outer">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown yamm-fw">
                                            <a @click="$store.dispatch('getPosts')" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Home</a>
                                        </li>
                                        <li class="dropdown yamm-fw" v-for="category in getTopCategories">
                                            <a @click="getPostsByCategorySlug(category.category_slug)" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ category.category_name }}</a>
                                        </li>
                                    </ul><!-- /.navbar-nav -->
                                    <div class="clearfix"></div>
                                </div><!-- /.nav-outer -->
                            </div><!-- /.navbar-collapse -->


                        </div><!-- /.nav-bg-class -->
                    </div><!-- /.navbar-default -->
                </div><!-- /.container-class -->

            </div><!-- /.header-nav -->
        </div>
    </header>
</template>

<script>
export default {
    name: "Header",
    data(){
        return {
            searchKey:''
        }
    },
    computed:{
        getTopCategories () {
            return this.$store.getters.categories
        }
    },
    mounted(){
        this.$store.dispatch("getTopCategories")
    },
    methods:{
        getPostsByCategorySlug(slug) {
            this.$store.dispatch("getPosts", {slug})
        },
        searchFunc : function(){
            let searchContent = this.searchKey
            this.$store.dispatch('algoliaSearchAction', searchContent)
        
        }

    }
}
</script>

<style scoped>

</style>
