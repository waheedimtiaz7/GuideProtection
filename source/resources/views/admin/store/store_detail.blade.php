@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Store Details
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Dropdown-->

            </div>
        </div>
        <div class="card-body">
            <form style="width: 100%" id="user" method="post" action="{{ route('admin.update_store',['id'=>$store->id]) }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" class="form-control required" tabindex="1" id="display_name" name="display_name" value="{{ $store->display_name }}">
                        </div>
                        <div class="form-group">
                            <label for="store_name">Store Name</label>
                            <input type="text" class="form-control required" tabindex="3" id="store_name" name="store_name" value="{{ $store->store_name }}">
                        </div>
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control required" tabindex="5" id="company_name" name="company_name" value="{{ $store->company_name }}">
                        </div>
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" class="form-control required" tabindex="7" id="url" name="url" value="{{ $store->url }}">
                        </div>
                        <div class="form-group">
                            <label for="alex_rank">Alex Rank</label>
                            <input type="text" class="form-control required" tabindex="9" id="alex_rank" name="alex_rank" value="{{ $store->alex_rank }}">
                        </div>
                        <div class="form-group">
                            <label for="setup_status">Setup Status</label>
                            <select class="form-control" name="setup_status" id="setup_status">
                                @foreach($setup_statuses as $setup_status)
                                    <option {{ $store->setup_status==$setup_status->value?"selected":"" }} value="{{ $setup_status->value }}">{{ $setup_status->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="shopify_name">Shopify Name</label>
                            <input type="text" class="form-control required" tabindex="2" id="shopify_name" name="shopify_name" value="{{ $store->shopify_name }}">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Merchandise Type</label>
                            <select class="form-control" name="category_id" id="category_id" tabindex="4">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sale_rep">Sale Rep</label>
                            <select class="form-control" name="sale_rep" id="sale_rep" tabindex="6">
                                <option></option>
                                @foreach($sale_reps as $sale_rep)
                                    <option value="{{ $sale_rep->id }}">{{ $sale_rep->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="paypal_account">Paypal Account</label>
                            <input type="text" class="form-control required" tabindex="8" id="paypal_account" name="paypal_account" value="{{ $store->paypal_account }}">
                        </div>
                        <div class="form-group">
                            <label for="variant_id_link_base">Variant ID Link Base</label>
                            <input type="text" class="form-control required" tabindex="10" id="variant_id_link_base" name="variant_id_link_base" value="{{ $store->variant_id_link_base }}">
                        </div>
                        <div class="form-group">
                            <label for="store_processing">Store Processing</label>
                            <select class="form-control" name="store_processing" id="store_processing">
                                <option {{ "Transaction"==$store->store_processing?"selected":"" }} value="Transaction">Transaction</option>
                                <option {{ "Bulk"==$store->store_processing?"selected":"" }} value="Bulk">Bulk</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Shipping account number</h5>
                        <div class="form-group">
                            <label for="ups_acc_no">UPS</label>
                            <input type="text" class="form-control required" tabindex="11" id="ups_acc_no" name="ups_acc_no" value="{{ $store->ups_acc_no }}">
                        </div>
                        <div class="form-group">
                            <label for="fedex_acc_no">FedEx</label>
                            <input type="text" class="form-control required" tabindex="12" id="fedex_acc_no" name="fedex_acc_no" value="{{ $store->fedex_acc_no }}">
                        </div>
                        <div class="form-group">
                            <label for="usps_acc_no">USPS</label>
                            <input type="text" class="form-control required" tabindex="13" id="usps_acc_no" name="usps_acc_no" value="{{ $store->usps_acc_no }}">
                        </div>
                        <div class="form-group">
                            <label for="dhl_acc_no">DHL</label>
                            <input type="text" class="form-control required" tabindex="14" id="dhl_acc_no" name="dhl_acc_no" value="{{ $store->dhl_acc_no }}">
                        </div>
                        <div class="form-group">
                            <label for="other_acc_no">Other</label>
                            <input type="text" class="form-control required" tabindex="15" id="other_acc_no" name="other_acc_no" value="{{ $store->other_acc_no }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Primary point of contact</h5>
                        <div class="form-group">
                            <label for="primary_poc_firstname">Firstname</label>
                            <input type="text" class="form-control required" tabindex="16" id="primary_poc_firstname" name="primary_poc_firstname" value="{{ $store->primary_poc_firstname }}">
                        </div>
                        <div class="form-group">
                            <label for="primary_poc_lastname">Lastname</label>
                            <input type="text" class="form-control required" tabindex="17" id="primary_poc_lastname" name="primary_poc_lastname" value="{{ $store->primary_poc_lastname }}">
                        </div>
                        <div class="form-group">
                            <label for="primary_poc_phone">Phone</label>
                            <input type="text" class="form-control required" tabindex="18" id="primary_poc_phone" name="primary_poc_phone" value="{{ $store->primary_poc_phone }}">
                        </div>
                        <div class="form-group">
                            <label for="primary_poc_email">Email</label>
                            <input type="text" class="form-control required" tabindex="19" id="primary_poc_email" name="primary_poc_email" value="{{ $store->primary_poc_email }}">
                        </div>
                        <div class="form-group">
                            <label for="primary_poc_title">Title</label>
                            <input type="text" class="form-control required" tabindex="20" id="primary_poc_title" name="primary_poc_title" value="{{ $store->primary_poc_title }}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
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
            rules: {
                confirm_password: {
                    equalTo: "#password"
                }
            }
        })
    </script>
@endsection
