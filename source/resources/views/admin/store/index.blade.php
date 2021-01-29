@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Store
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>

            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-checkable" id="kt_datatable">
                <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Setup Status</th>
                    <th>URL</th>
                    <th>Shopify Name</th>
                    <th>Merchandise Type</th>
                    <th>Sales Rep</th>
                    <th>Date Installed</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stores as $store)
                    <tr>
                        <td><a onclick="open">{{ $store->display_name }}</a></td>
                        <td>{{ $store->setup_status }}</td>
                        <td>{{ $store->setup_status }}</td>
                        <td>{{ $store->shopify_name }}</td>
                        <td></td>
                        <td>{{ $store->sales_rep }}</td>
                        <td>{{ !empty($store->change_at)?date('m/d/Y',strtotime($store->change_at)):"" }}</td>
                        <td><a href="{{ route('admin.store_pricing',['id'=>$store->id]) }}">View Pricing</a> |
                            <a href="{{ route('admin.store_edit',['id'=>$store->id]) }}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('script')

@endsection
