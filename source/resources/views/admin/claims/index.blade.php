@extends("admin.layouts.app")
@section('style')
    <link href="{{ asset("/") }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection
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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">All Claims</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="#" class="text-muted">Claims</a>
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
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Claims
                                <span class="d-block text-muted pt-2 font-size-sm">Showing All Claims</span></h3>
                        </div>
                        <div class="card-toolbar">

                            <!--begin::Button-->
                            <a href="#" onclick="event.preventDefault();location.reload()" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Refresh
                            </a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="mb-15" id="filter_form">
                            <div class="row mb-8">
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Claim Date:</label>
                                    <div class="input-daterange input-group" id="kt_datepicker">
                                        <input type="text" class="form-control datatable-input" name="date_from" id="date_from" placeholder="From" data-col-index="5" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-ellipsis-h"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control datatable-input" name="date_to" id="date_to" placeholder="To" data-col-index="5" />
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label for="claim_status">Claim Status:</label>
                                    <select class="form-control datatable-input" data-col-index="6" id="claim_status" name="claim_status">
                                        <option value="">All</option>
                                        @foreach($claim_statuses as $claim_status)
                                            <option {{ $claim_status->value==1?"selected":"" }} value="{{ $claim_status->value }}">{{ $claim_status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label for="reorder_status">Re-order Status:</label>
                                    <select class="form-control datatable-input" data-col-index="7" id="reorder_status" name="reorder_status">
                                        <option value="">All</option>
                                        @foreach($reorder_statuses as $reorder_status)
                                            <option value="{{ $reorder_status->value }}">{{ $reorder_status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-8">
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label for="rep">Rep:</label>
                                    <select class="form-control datatable-input" data-col-index="0" id="rep" name="rep">
                                        <option value="">All</option>
                                        @foreach($reps as $rep)
                                            <option value="{{ $rep->id }}">{{ $rep->firstname.' '.$rep->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label for="shop_id">Store:</label>
                                    <select class="form-control datatable-input" data-col-index="2" name="shop_id" id="shop_id">
                                        <option value="">All</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->shopify_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label for="escalated">Escalated:</label>
                                    <select class="form-control datatable-input" name="escalated" id="escalated" data-col-index="">
                                        <option value="">All</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-primary--icon" type="submit">
                                        <span>
                                            <i class="la la-search"></i>
                                            <span>Search</span>
                                        </span>
                                    </button>&#160;&#160;
                                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset" onclick="resetForm()" type="button">
                                        <span>
                                            <i class="la la-close"></i>
                                            <span>Reset</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--begin: Datatable-->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-checkable table-striped" id="k_datatable">
                            <thead>
                                <tr>
                                    <th>Rep</th>
                                    <th>Order Number</th>
                                    <th>Store</th>
                                    <th>Claim Date</th>
                                    <th>Hold Until</th>
                                    <th>Name</th>
                                    <th>Claim Status</th>
                                    <th>Reorder Status</th>
                                    <th>Reorder Date</th>
                                    <th>Reorder #</th>
                                    <th>Reorder Trk</th>
                                    <th>Reorder Notify</th>
                                    <th>Track Notify</th>
                                    <th>Final Email</th>
                                    <th>Escalated</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--end::Global Theme Bundle-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset("/") }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset("/") }}/assets/js/pages/crud/datatables/search-options/advanced-search.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            }
        });
        function resetForm(){
            $("input[name='date_from']").val("");
            $("input[name='date_to']").val("");
            $("select[name='reorder_status']").val("");
            $("select[name='claim_status']").val("");
            $("select[name='rep']").val("");
            $("select[name='shop_id']").val("");
            $("select[name='escalated']").val("");
            claims.draw();
        }
        var claims=$('#k_datatable').DataTable({
            responsive: true,
            // Pagination settings
            lengthMenu: [10, 25, 50, 100],
            "order": [[ 3, "asc" ]],
            pageLength: 25,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.get_claims') }}',
                method: 'POST',
                data:function(d){
                    d._token="{{ csrf_token() }}";
                    d.date_from=$("input[name='date_from']").val();
                    d.date_to=$("input[name='date_to']").val();
                    d.reorder_status=$("select[name='reorder_status']").val();
                    d.claim_status=$("select[name='claim_status']").val();
                    d.rep=$("select[name='rep']").val();
                    d.shop_id=$("select[name='shop_id']").val();
                    d.escalated=$("select[name='escalated']").val();
                },
            },
            columns: [
                {data: 'representative_name', name: 'representative_name'},
                {data: 'cart_ordernumber', name: 'cart_ordernumber'},
                {data: 'shop.display_name', name: 'shop.display_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'hold_until_date', name: 'hold_until_date'},
                {data: 'customer_lastname', name: 'customer_lastname'},
                {data: 'claim_status', name: 'claim_status'},
                {data: 'reorder_status', name: 'reorder_status'},
                {data: 'reorder_date', name: 'reorder_date'},
                {data: 'reorder_cartnumber', name: 'reorder_cartnumber'},
                {data: 'reorder_trackingnumber', name: 'reorder_trackingnumber'},
                {data: 'reorder_notify', name: 'reorder_notify'},
                {data: 'track_notify', name: 'track_notify'},
                {data: 'final_email', name: 'final_email'},
                {data: 'is_escalated', name: 'is_escalated'}
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val()).draw();
                        });
                });
            }
        });
        $("#filter_form").submit(function (e) {
            var from = $("input[name='date_from']").val();
            var to = $("input[name='date_to']").val();
            e.preventDefault();
            if(Date.parse(from) > Date.parse(to)){
                alert("End date should be greater than from date");
            }else{
                claims.draw();
            }



        })
    </script>
@endsection
