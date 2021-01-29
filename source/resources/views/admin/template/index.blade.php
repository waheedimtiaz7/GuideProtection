@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Email Templates
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>

            </div>
            <div class="card-toolbar">
                {{--<button type="button" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#add_template">
                    Add New
                </button>--}}
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table id="tasks" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>{{ $template->title }}</td>
                        <td>{{ $template->subject }}</td>
                        <td>
                            <a class="btn btn-info" href="#" onclick="getCategory('{{ $template->id }}')">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="add_template">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.template_store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">New Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Type">
                        </div>
                        <div class="form-group">
                            <label for="claim_status">Claim Status</label>
                            <select class="form-control" name="claim_status" id="claim_status">
                                <option value=""></option>
                                @foreach($claim_statuses as $claim_status)
                                    <option value="{{ $claim_status->value }}">{{ $claim_status->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reorder_status">Reorder Status</label>
                            <select class="form-control" name="reorder_status" id="reorder_status">
                                <option value=""></option>
                                @foreach($reorder_statuses as $reorder_status)
                                    <option value="{{ $reorder_status->value }}">{{ $reorder_status->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">Template</label>
                            <textarea class="form-control" name="detail" id="detail"></textarea>
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
    <div class="modal fade" id="edit_template">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.template_update') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Update Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter title" required="required">
                        </div>
                        <div class="form-group">
                            <label for="edit_subject">Subject</label>
                            <input type="text" class="form-control" id="edit_subject" name="subject" placeholder="Enter subject" required="required">
                            <input type="hidden" class="form-control" id="template_id" name="template_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_claim_status">Claim Status</label>
                            <select class="form-control" name="claim_status" id="edit_claim_status">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_reorder_status">Reorder Status</label>
                            <select class="form-control" name="reorder_status" id="edit_reorder_status">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_detail">Template</label>
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
                function getCategory(id) {
                    $.ajax({
                        url:"{{ url('admin/template/edit/') }}"+"/"+id,
                        success:function (data) {
                            if(data.success){
                                $("#edit_title").val(data.category.title);
                                $("#edit_subject").val(data.category.subject);
                                var claim_status='';
                                claim_status+='<option value=""></option>';
                                $.each(data.claim_statuses,function (index,value) {
                                    if(value.value===data.category.claim_status){
                                        claim_status+='<option selected  value="'+ value.value +'">'+value.title+'</option>';
                                    }else{
                                        claim_status+='<option  value="'+ value.value +'">'+value.title+'</option>';
                                    }

                                })
                                $("#edit_claim_status").html(claim_status)
                                var reorder_status='';
                                reorder_status+='<option value=""></option>';
                                $.each(data.reorder_statuses,function (index,value) {
                                    if(value.value===data.category.reorder_status){
                                        reorder_status+='<option selected  value="'+ value.value +'">'+value.title+'</option>';
                                    }else{
                                        reorder_status+='<option  value="'+ value.value +'">'+value.title+'</option>';
                                    }

                                })
                                $("#edit_reorder_status").html(reorder_status)
                                CKEDITOR.instances['edit_detail'].setData(data.category.detail);
                                $("#template_id").val(data.category.id);
                                $("#edit_template").modal("show");
                            }
                        }
                    })
                }
            </script>
@endsection