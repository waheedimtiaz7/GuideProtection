@extends('layouts.app')
@section('content')
<style>
    #pageloader
    {
        background: rgba(64, 62, 62, 0.8);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }
    .display_block {
        display: block !important;
    }

    #pageloader img
    {
        left: 50%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
    }
</style>
<header class="header step-2">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Logo -->
                <div class="logo_img">
                    <img src="{{ asset('assets') }}/img/logo.png" alt="logo image">
                </div>
            </div>
            <div class="col-md-8 d-flex justify-content-center justify-content-md-end">
                <div id="our-process">
                    <div class="container">
                        <div class="row">
                            <ul class="process-wrapp">
                                <li class="whitecolor wow fadeIn" data-wow-delay="300ms">
                                    <span class="active-step">01</span>
                                </li>
                                <li class="whitecolor wow fadeIn" data-wow-delay="400ms">
                                    <span class="active-step">02</span>
                                </li>
                                <li class="whitecolor wow fadeIn" data-wow-delay="500ms">
                                    <span class="pro-step">03</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="pageloader">
    <img src="{{ asset('assets/img/loading.gif') }}" alt="processing..." />
</div>
<!-- End Header -->
<form id="claim_form">
    {{ csrf_field() }}
<!-- Start Banner -->
    <section class="page-title">
        <div class="container">
            <h2>Claim Form</h2>
            <ul class="page-breadcrumb">
                <li><a href="{{ url("/") }}"><span class="icon fas fa-home"></span>Home</a></li>
                <li>Claim Form</li>
            </ul>
        </div>
    </section>
    <!-- End Banner -->

    <!-- Start Order Form -->
    <section class="ship-form-2">
        <div class="container">

            <div class="row py-5">
                <div class="col-md-12">
                    <h3 class="mb-5 text-blue">{{ $store->shopify_name }}</h3>
                    <div class="card rounded border-0">
                        <div class="card-body rounded">
                            <div class="table-details">
                                <span>Order Date: {{ date('m/d/y',strtotime($order->orderdate)) }}</span>
                            </div>
                            <div class="table-responsive">
                                <table style="width:100%" class="table table-striped table-bordered">
                                    <thead class="table-head">
                                    <tr>
                                        <th>Claimed Items</th>
                                        <th>Qty</th>
                                        <th>Description</th>
                                        <th>SKU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->order_detail as $k=>$detail)
                                        @if($detail->title!='Guide Protection' && $detail->title!='Guide protection')
                                            <tr>
                                                <td><input name="item[]" type="checkbox" class="box item" value="{{ $detail->id }}"></td>
                                                <td><input name="qty[]" id="qty_{{ $detail->id }}" disabled="disabled"  value="{{ $detail->qty }}"></td>
                                                <td>{{ $detail->title }}</td>
                                                <td>{{ $detail->sku }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Order Form -->

    <!-- Start Drop Down -->
    <section class="dropdown py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="sub_heading">What Happened? (Please note that we do not cover manufacturing defects)</p>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="incident_type" id="incident_type">
                        @foreach($incident_types as $incident_type)
                            <option value="{{ $incident_type->value }}">{{ $incident_type->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>
    <!-- End Drop Down -->

    <!-- Start Description -->
    <section class="description">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="sub_heading">Description of incident</p>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Message" id="incident_description" name="incident_description"></textarea>
                        <div class="tracking-num py-5">
                            <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                            <p class="sub_heading">Tracking Number</p>
                            <input type="text" name="cart_trackingnumber" id="cart_trackingnumber">
                            <span class="mx-2">(if optional)</span>
                            <p>Note that items can only be re-shipped to the orignal addresses.</p>
                            <div class="alert-danger py-3 hidden"></div>
                            <button type="submit" class="btn contact_btn btn-medium btn-blue btn-rounded my-4">Submit </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
@section('script')
    <script>
        $('.item').change(function() {
            if(this.checked) {
              $("#qty_"+$(this).val()).removeAttr('disabled')
            }else{
                $("#qty_"+$(this).val()).attr('disabled','disabled')
            }
        });
        $("#claim_form").on('submit',function (e) {
            e.preventDefault();

            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0){
                $(".alert-danger").removeClass("hidden");
                $(".alert-danger").html("  Please select at least one item and include a description.");
                // cancel submit
                return false;
            }else{
                $("#pageloader").addClass('display_block');
                $.ajax({
                    url:"{{ url('submit-claim-form') }}",
                    data:$(this).serialize(),
                    type:"post",
                    success:function (data) {
                        $("#pageloader").removeClass('display_block');
                        if(data.success){
                            window.location.href="{{ url("success-page") }}"
                        }else{
                            alert("Order not found. If you think you'r receiving this by mistake, please contact your store's customer service.")
                        }
                    }
                })
            }

        })
    </script>
@endsection
