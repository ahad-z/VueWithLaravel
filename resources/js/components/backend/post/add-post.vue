<template>
    <div>
        <section class="content pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Add Your Post</h3>
                                <router-link to="/posts" class="btn btn-primary btn-sm" style="float: right">All Post</router-link>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <form class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="category" class="col-sm-2 col-form-label">Add Your Post</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  id="category" placeholder="Enter Your Category..."  >
                                            </div>
                                        </div>
                                        <div class="form-group-row">
                                            <label for="category" class="col-sm-2 col-form-label">Status</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" value="1"  name="status">
                                                <label class="form-check-label" for="inactive">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" value="0"  name="status">
                                                <label class="form-check-label" for="inactive">Inactive</label>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit"  class="btn btn-info">Add</button>
                                        <button type="reset" class="btn btn-default float-right">Reset</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "add-post",
    data: function () {
        return {

        }
    },
    methods:{

    }
}
</script>

<style scoped>

</style>
