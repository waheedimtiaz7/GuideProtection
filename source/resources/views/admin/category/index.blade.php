@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Categories
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>

            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#add_category">
                    Add New
                </button>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table id="tasks" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->title }}</td>
                        <td>
                            <a class="btn btn-info" href="#" onclick="getCategory('{{ $category->id }}')">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="add_category">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.category_store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">New Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="edit_category">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.category_update') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Update Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter Title" required="required">
                            <input type="hidden" class="form-control" id="category_id" name="category_id">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
@endsection
@section('script')
    <script>
        function getCategory(id) {
            $.ajax({
                url:"{{ url('admin/category/edit/') }}"+"/"+id,
                success:function (data) {
                    if(data.success){
                        $("#edit_title").val(data.category.title);
                        $("#category_id").val(data.category.id);
                        $("#edit_category").modal("show");
                    }
                }
            })
        }
    </script>
@endsection