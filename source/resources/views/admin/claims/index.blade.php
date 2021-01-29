@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Claims
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <form id="filter_form" class="w-100">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="date_from">Claim Date From/ To</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" id="date_to" name="date_to">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="claim_status">Claim Status</label>
                            <select name="claim_status" id="claim_status" class="form-control">
                                <option value="">All</option>
                                @foreach($claim_statuses as $claim_status)
                                    <option value="{{ $claim_status->id }}">{{ $claim_status->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="rep">Claim Rep</label>
                            <select name="rep" class="form-control" id="rep">
                                <option value="">All</option>
                                @foreach($reps as $rep)
                                    <option value="{{ $rep->id }}">{{ $rep->firstname.' '.$rep->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="reorder_status">Reorder Status</label>
                            <select name="reorder_status" id="reorder_status" class="form-control">
                                <option value="">All</option>
                                @foreach($reorder_statuses as $reorder_status)
                                    <option value="{{ $reorder_status->id }}">{{ $reorder_status->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="shop_id">Store</label>
                            <select name="shop_id" class="form-control" id="shop_id">
                                <option value="">All</option>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->shopify_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="escalated">Escalated</label>
                            <select name="escalated" id="escalated" class="form-control">
                                <option value="">All</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mb-10">
                        <button type="button" onclick="resetForm()" class="btn btn-secondary float-right" id="reset">Reset</button>
                        <button type="submit" class="btn btn-secondary float-right mr-5">Filter</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-checkable" id="kt_datatable" data-page-length='25'>
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
@endsection
@section('script')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

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
            $("select[name='store']").val("");
            $("select[name='escalated']").val("");
            claims.draw();
        }
        var claims=$('#kt_datatable').DataTable({
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
                    d.store=$("select[name='store']").val();
                    d.escalated=$("select[name='escalated']").val();
                },
            },
            columns: [
                {data: 'representative_name', name: 'representative_name'},
                {data: 'store_ordernumber', name: 'store_ordernumber'},
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
