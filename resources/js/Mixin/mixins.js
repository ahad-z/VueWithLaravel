import Vue from  "vue"
Vue.mixin({
    methods:{
        confirm:function(callback){
            Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then((result) => {
                if (result.isConfirmed) callback();
            })
        },
        multipleCheck: function (){
            this.selected = [];
            this.isSelected = false;
            this.selectedAll = false;
            this.$store.dispatch("getCategories");
        },
        multipleCheckPosts: function (){
            this.selected = [];
            this.isSelected = false;
            this.selectedAll = false;
            this.$store.dispatch("getPosts")
        },

    }

})



