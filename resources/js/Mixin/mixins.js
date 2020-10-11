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
        },
        fileLink:function(name){
            if(name !==null && name.length < 256){
                return '/uploads/post/' + name
            }else{
                return  this.form.thumbnail
            }
        },
         lodeImg:function(event){
            let file = event.target.files[0]
             if(file.type ==='image/jpeg' || file.type === 'image/png'){
                if(file.size <= 1024000){
                    let reader = new FileReader()
                    const FatherThis = this
                    reader.onload = function(e){
                        FatherThis.form.thumbnail = e.target.result
                    }
                    reader.readAsDataURL(file)
                }else{
                    toastr.warning('Size less than 1 MB')
                }
            }else{
                toastr.warning('Image Extension must be "JPEG" and "PNG" ')
            }
        }
    }

})



