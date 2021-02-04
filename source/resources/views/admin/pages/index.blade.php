@extends("admin.layouts.app")
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">All Pages</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.static_pages") }}" class="text-muted">Pages</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Pages
                                <span class="d-block text-muted pt-2 font-size-sm">Showing All Pages</span></h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#add_category">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table id="tasks" class="table table-striped">
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
            </div>
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