@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Static Pages
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
                    <th>Url</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td><a target="_blank" href="{{ url('/'.$page->slug) }}">{{ $page->slug }}</a></td>
                        <td>
                            <a class="btn btn-info" href="#" onclick="getPage('{{ $page->id }}')">Edit</a>
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
                <form action="{{ route('admin.page_store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">New Page</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Page Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="detail">Detail</label>
                            <textarea name="detail" id="detail" class="form-control"></textarea>
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
                <form action="{{ route('admin.page_update') }}" method="post">
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
                            <input type="hidden" class="form-control" id="page_id" name="page_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_detail">Detail</label>
                            <textarea name="detail" id="edit_detail" class="form-control"></textarea>
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
            <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script>
        let editor;
        CKEDITOR.replace( 'detail' );
        CKEDITOR.replace( 'edit_detail' );
        function getPage(id) {
            $.ajax({
                url:"{{ url('admin/static-page/edit/') }}"+"/"+id,
                success:function (data) {
                    if(data.success){
                        $("#edit_title").val(data.page.title);
                        $("#page_id").val(data.page.id);
                        CKEDITOR.instances['edit_detail'].setData(data.page.detail);
                        $("#edit_category").modal("show");
                    }
                }
            })
        }
    </script>
@endsection