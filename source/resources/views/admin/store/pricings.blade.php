@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Store Pricing
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>

            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#add_pricing">
                    Add New
                </button>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-checkable" id="kt_datatable">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
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
                        <td>{{ $price->range_from }}</td>
                        <td>{{ $price->range_to }}</td>
                        <td><a href="#" onclick="editPrice('{{ $price->title }}','{{ $price->id }}','{{ $price->price }}','{{ $price->range_from }}','{{ $price->range_to }}')">Edit</a>
                            <a href="{{ route('admin.store_price_delete',['id'=>$price->id]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
    function editPrice(title,id,price,range_from,range_to) {
        $("#edit_title").val(title);
        $("#edit_range_from").val(range_from);
        $("#edit_price").val(price);
        $("#edit_range_to").val(range_to);
        $("#price_id").val(id);
        $("#edit_pricing").modal("show")
    }
</script>
@endsection