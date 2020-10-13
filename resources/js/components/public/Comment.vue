<template>
    <div>
        <div class="card">
            <div class="card-header">Leave a Comment</div>
            <div class="card-body">
                <form @submit.prevent="addVote">
                    <input type="hidden"    v-model="form.id">
                    <textarea rows="4" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('body') }" name="body" spellcheck="true" v-model="form.body"></textarea>
                    <has-error :form="form" field="body"></has-error>
                    <button type="submit"  :disabled="form.busy" style="margin-top: 5px" class="btn btn-primary btn-sm">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",
    data: function () {
        return {
            form: new Form({
                body:null,
                id:''

            })
        }
    },
    computed:{

    },
    mounted(){

    },
    methods:{
        addVote:function(){
            const currentThis = this;
            this.form.post('/votes').then(response => {
                if(response.data.status){
                    Toast.fire({
                        icon: 'success',
                        title: 'Post submitted in successfully'
                    })
                    currentThis.form.body = null;
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Something went Wrong!'
                    })
                }

            })

        }
    }
}
</script>

<style scoped>

</style>
