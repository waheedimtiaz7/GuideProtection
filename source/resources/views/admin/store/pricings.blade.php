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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">All Pricing</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.stores") }}" class="text-muted">Stores</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="#" class="text-muted">Pricing</a>
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
                            <h3 class="card-label">Pricing
                                <span class="d-block text-muted pt-2 font-size-sm">Showing All Pricing</span></h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="#" class="btn btn-secondary font-weight-bolder mr-2">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>Publish & Exit
                            </a>
                            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#add_pricing">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>New Price Level
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-checkable" id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Guide Price</th>
                                <th>Start Total</th>
                                <th>End Total</th>
                                
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prices as $price)
                                <tr>
                                    <td>{{ $price->title }}</td>
                                    <td>{{ $price->price }}</td>
                                    <td>{{ $price->guide_price }}</td>
                                    <td>{{ $price->range_from }}</td>
                                    <td>{{ $price->range_to }}</td>
                                    <td><a href="#" onclick="editPrice('{{ $price->title }}','{{ $price->id }}','{{ $price->price }}','{{ $price->guide_price }}','{{ $price->range_from }}','{{ $price->range_to }}')">Edit</a>
                                        <a href="{{ route('admin.store_price_delete',['id'=>$price->id]) }}">Delete</a>
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
    <div class="modal fade" id="add_pricing">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.store_price_create') }}" method="post" id="add_price">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Shop Pricing</h4>
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
                            <label for="range_from">Start Total</label>
                            <input type="number" step="any" min="0"  class="form-control" id="range_from" name="range_from" placeholder="Enter start range">
                        </div>
                        <div class="form-group">
                            <label for="range_to">End Total</label>
                            <input type="number" step="any" min="1"  class="form-control" id="range_to" name="range_to" placeholder="Enter end range">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" id="price" name="price" placeholder="Enter price">
                            <input type="hidden" class="form-control" id="shop_id" name="shop_id" placeholder="Enter Type" value="{{ $shop_id }}">
                        </div>
                         <div class="form-group">
                            <label for="price">Guide Price</label>
                            <input type="number" step="any" class="form-control" id="guide_price" name="guide_price" placeholder="Enter guide price">
                            
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
    <div class="modal fade" id="edit_pricing">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.store_price_update') }}" method="post" id="edit_prices">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Shop Pricing</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="edit_range_from">Start Total</label>
                            <input type="number" step="any" minlength="0" class="form-control" id="edit_range_from" name="edit_range_from" placeholder="Enter start range">
                        </div>
                        <div class="form-group">
                            <label for="edit_range_to">End Total</label>
                            <input type="number" step="any" minlength="1" class="form-control" id="edit_range_to" name="edit_range_to" placeholder="Enter end range">
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" step="any" class="form-control" id="edit_price" name="price" placeholder="Enter price">
                            <input type="hidden" class="form-control" id="edit_shop_id" name="shop_id" placeholder="Enter Type" value="{{ $shop_id }}">
                            <input type="hidden" class="form-control" id="price_id" name="price_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Guide Price</label>
                            <input type="number" step="any" class="form-control" id="edit_guide_price" name="guide_price" placeholder="Enter guide price">
                            
                            
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
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    $('#kt_datatable').DataTable({
        "searching": false,
        lengthChange: false,
        order: [[2, 'asc']]
    });
    $.validator.addMethod('lessThan', function(value, element, param) {
        return this.optional(element) || value <= $(param).val();
    }, 'Invalid value');
    $.validator.addMethod('greaterThan', function(value, element, param) {
        return this.optional(element) || value >= $(param).val();
    }, 'Invalid value');
    $("#add_price").validate({
        rules: {
            title: {
                required: true
            },range_from: {
                required: true,
                lessThan:'input[name="range_to"]'
            },range_to: {
                required: true,
                greaterThan: 'input[name="range_from"]'
            }
        },
        messages: {
            range_from: {lessThan: 'Must be less than or equal to End Total'},
            range_to: {greaterThan: 'Must be greater than or equal to Start Total'},
        }
    })
    $("#edit_prices").validate({
        rules: {
            title: {
                required: true
            },range_from: {
                required: true,
                lessThan:'input[name="edit_range_to"]'
            },range_to: {
                required: true,
                greaterThan: 'input[name="edit_range_from"]'
            }
        },
        messages: {
            range_from: {lessThan: 'Must be less than or equal to End Total'},
            range_to: {greaterThan: 'Must be greater than or equal to Start Total'},
        }
    })
    function editPrice(title,id,price,guide_price,range_from,range_to) {
        $("#edit_title").val(title);
        $("#edit_range_from").val(range_from);
        $("#edit_price").val(price);
        $("#edit_guide_price").val(guide_price);
        $("#edit_range_to").val(range_to);
        $("#price_id").val(id);
        $("#edit_pricing").modal("show")
    }
</script>
@endsection
