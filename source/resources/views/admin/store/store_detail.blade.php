@extends("admin.layouts.app")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Store</h5>
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
                                <a href="#" class="text-muted">Detail</a>
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
                <form style="width: 100%" id="user" method="post" action="{{ route('admin.update_store',['id'=>$store->id]) }}">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Store
                                    <span class="d-block text-muted pt-2 font-size-sm">Store detail</span>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <label for="support_issue">
                                <input type="checkbox" class="checkbox-success" name="support_issue" id="support_issue">&nbsp;&nbsp;Support Issue</label>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="display_name" class="col-sm-3 col-form-label">Display Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" tabindex="1" id="display_name" name="display_name" value="{{ $store->display_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="store_name" class="col-sm-3 col-form-label">Store Name*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" tabindex="3" id="store_name" name="store_name" value="{{ $store->store_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_name" class="col-sm-3 col-form-label">Company Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="5" id="company_name" name="company_name" value="{{ $store->company_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="url" class="col-sm-3 col-form-label">Url*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" tabindex="7" id="url" name="url" value="{{ $store->url }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alex_rank" class="col-sm-3 col-form-label">Alex Rank</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control " tabindex="9" id="alex_rank" name="alex_rank" value="{{ $store->alex_rank }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="setup_status" class="col-sm-3 col-form-label">Setup Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="setup_status" id="setup_status">
                                                @foreach($setup_statuses as $setup_status)
                                                    <option {{ $store->setup_status==$setup_status->value?"selected":"" }} value="{{ $setup_status->value }}">{{ $setup_status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_installed" class="col-sm-3 col-form-label">Date Installed</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="date_uninstalled" readonly="readonly" id="date_installed" class="form-control" value="{{ !empty($store->date_installed)&& $store->date_installed!=null?date('m/d/Y',strtotime($store->date_installed)):"" }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="shopify_name"  class="col-sm-3 col-form-label">Shopify Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control" tabindex="2" id="shopify_name" name="shopify_name" value="{{ $store->shopify_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="category_id" class="col-sm-3 col-form-label">Merchandise Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="category_id" id="category_id" tabindex="4">
                                                <option></option>
                                                @foreach($categories as $category)
                                                    <option {{ $category->id==$store->categories[0]->id?"selected":"" }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sale_rep" class="col-sm-3 col-form-label">Sale Rep</label>
                                        <div class="col-sm-9">
                                        <select class="form-control" name="sales_rep" id="sales_rep" tabindex="6">
                                            <option></option>
                                            @foreach($sale_reps as $sale_rep)
                                                <option {{ $sale_rep->id==$store->sales_rep?"selected":"" }} value="{{ $sale_rep->id }}">{{ $sale_rep->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="paypal_account" class="col-sm-3 col-form-label">Paypal Account</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="8" id="paypal_account" name="paypal_account" value="{{ $store->paypal_account }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="variant_id_link_base" class="col-sm-3 col-form-label">Variant ID Link Base*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" tabindex="10" id="variant_id_link_base" name="variant_id_link_base" value="{{ $store->variant_id_link_base }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="store_processing" class="col-sm-3 col-form-label">Store Processing</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="store_processing" id="store_processing">
                                                <option {{ "Transaction"==$store->store_processing?"selected":"" }} value="Transaction">Transaction</option>
                                                <option {{ "Bulk"==$store->store_processing?"selected":"" }} value="Bulk">Bulk</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_uninstalled" class="col-sm-3 col-form-label">Date Uninstalled</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="date_uninstalled" readonly="readonly" id="date_uninstalled" class="form-control" value="{{ !empty($store->date_uninstalled)&& $store->date_uninstalled!=null?date('m/d/Y',strtotime($store->date_uninstalled)):"" }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-5 mb-5">
                                        <h5>Shipping account number</h5>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ups_acc_no" class="col-sm-3 col-form-label">UPS</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="11" id="ups_acc_no" name="ups_acc_no" value="{{ $store->ups_acc_no }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fedex_acc_no" class="col-sm-3 col-form-label">FedEx</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="12" id="fedex_acc_no" name="fedex_acc_no" value="{{ $store->fedex_acc_no }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="usps_acc_no" class="col-sm-3 col-form-label">USPS</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="13" id="usps_acc_no" name="usps_acc_no" value="{{ $store->usps_acc_no }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dhl_acc_no" class="col-sm-3 col-form-label">DHL</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="14" id="dhl_acc_no" name="dhl_acc_no" value="{{ $store->dhl_acc_no }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="other_acc_no" class="col-sm-3 col-form-label">Other</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="15" id="other_acc_no" name="other_acc_no" value="{{ $store->other_acc_no }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-5 mb-5">
                                        <h5>Primary point of contact</h5>
                                    </div>
                                    <div class="form-group row">
                                        <label for="primary_poc_firstname" class="col-sm-3 col-form-label">Firstname</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="16" id="primary_poc_firstname" name="primary_poc_firstname" value="{{ $store->primary_poc_firstname }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="primary_poc_lastname" class="col-sm-3 col-form-label">Lastname</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="17" id="primary_poc_lastname" name="primary_poc_lastname" value="{{ $store->primary_poc_lastname }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="primary_poc_phone" class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="18" id="primary_poc_phone" name="primary_poc_phone" value="{{ $store->primary_poc_phone }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="primary_poc_email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="19" id="primary_poc_email" name="primary_poc_email" value="{{ $store->primary_poc_email }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="primary_poc_title" class="col-sm-3 col-form-label">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="20" id="primary_poc_title" name="primary_poc_title" value="{{ $store->primary_poc_title }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="notes" class="col-sm-3 col-form-label">Notes (don't delete history)</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" style="min-height: 500px" id="notes" name="notes">{{ $store->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset("/") }}assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
    @if(Session::has('error'))
        <script>
            swal.fire({
                text: '{{ Session::get('error') }}',
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            });
        </script>
    @endif
    @if(Session::has('success'))
        <script>
            swal.fire({
                text: '{{ Session::get('success') }}',
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            });
        </script>
    @endif
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script>
        $("#user").validate({
        })
    </script>
@endsection
