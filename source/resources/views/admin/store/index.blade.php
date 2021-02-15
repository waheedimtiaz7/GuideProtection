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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">All Stores</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.stores") }}" class="text-muted">Stores</a>
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
                            <h3 class="card-label">Stores
                                <span class="d-block text-muted pt-2 font-size-sm">Showing All Stores</span></h3>
                        </div>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-striped" id="stores">
                            <thead>
                            <tr>
                                <th>Display Name</th>
                                <th>Store Status</th>
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
                                <tr class="{{ $store->support_issue==1?"bg-danger-o-35":"" }} ">
                                    <td><a onclick="open">{{ $store->display_name }}</a></td>
                                    <td>{{ $store->store_status==1?"Active":"In-Active" }}</td>
                                    <td>{{ $store->setup_status==1?"Installed":"Not Installed" }}</td>
                                    <td><a href="{{$store->url}}" target="_blank">{{ $store->url }}</a></td>
                                    <td>{{ $store->shopify_name }}</td>
                                    <td>{{ count($store->categories)?$store->categories[0]->title:"" }}</td>
                                    <td>{{ !empty($store->rep)?$store->rep->name:"" }}</td>
                                    <td>{{ date('m/d/Y',strtotime($store->created_at)) }}</td>
                                    <td><a href="{{ route('admin.store_pricing',['id'=>$store->id]) }}">View Pricing</a> |
                                        <a href="{{ route('admin.store_edit',['id'=>$store->id]) }}">Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset("/") }}assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset("/") }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset("/") }}/assets/js/pages/crud/datatables/search-options/advanced-search.js"></script>
    <script>
        $('#stores').DataTable({
            responsive: true,
            // Pagination settings
            lengthMenu: [10, 25, 50, 100],
            "order": [[ 2, "asc" ]],
            pageLength: 25,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            searchDelay: 500});
    </script>
@endsection
