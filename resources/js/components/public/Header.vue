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
                                    <input class="search-field"  id="search-input"  placeholder="Search here...">
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
var autocomplete = require('autocomplete.js');
export default {
    name: "Header",
    data(){
        return {
           /* searchKey:''*/
        }
    },
    computed:{
        getTopCategories () {
            return this.$store.getters.categories
        }
    },
    mounted(){
        this.$store.dispatch("getTopCategories")

        /* For algolia auto search */
         var client = algoliasearch('FGUP2LPWO6', '01333ca43a060eda292f382c263c1999')
          var index = client.initIndex('title');
          autocomplete('#search-input', { hint: false }, [
            {
              source: this.newHitsSource(index, { hitsPerPage: 5 }),
              displayKey: 'post_slug',
              templates: {
                suggestion: function(suggestion) {
                  return suggestion._highlightResult.post_slug.value;
                }
              }
            }
          ]).on('autocomplete:selected', function(event, suggestion, dataset, context) {
            console.log( suggestion.id);
          });

          /* End Here */
    },
    methods:{
        /* For algolia search*/
        newHitsSource(index, params) {
            return function doSearch(query, cb) {
              index
                .search(query, params)
                .then(function(res) {
                  cb(res.hits, res);
                })
                .catch(function(err) {
                  console.error(err);
                  cb([]);
                });
            };
          },
          /*  End Here   */

        getPostsByCategorySlug(slug) {
            this.$store.dispatch("getPosts", {slug})
        },
       /* searchFunc : function(){
            let searchContent = this.searchKey
            this.$store.dispatch('algoliaSearchAction', searchContent)
        
        }*/

    }
}


</script>

<style scoped>

 .algolia-autocomplete {
    width: 100%;
  }
  .algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
    width: 100%;
  }
  .algolia-autocomplete .aa-hint {
    color: #999;
  }
  .algolia-autocomplete .aa-dropdown-menu {
    width: 100%;
    background-color: #fff;
    border: 1px solid #999;
    border-top: none;
  }
  .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
    cursor: pointer;
    padding: 5px 4px;
  }
  .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
    background-color: #B2D7FF;
  }
  .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
    font-weight: bold;
    font-style: normal;
  }
</style>
