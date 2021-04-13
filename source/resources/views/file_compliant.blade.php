@extends('layouts.app')
@section('content')
<div id="pageloader">
    <div class="loader"></div>
</div>
<header class="header step-2">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Logo -->
                <div class="logo_img">
                    <img src="{{ asset('assets/img/second_logo.png') }}" alt="logo image">
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
                                <li class="whitecolor wow fadeIn" data-wow-delay="600ms">
                                    <span class="pro-step">04</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header -->
<form id="claim_form" action="{{ url('get-claim-details') }}" method="post">
    {{ csrf_field() }}
<!-- Start Banner -->
    <section class="page-title">
        <div class="container">
            <h2>Claim Form</h2>
        </div>
    </section>
    <!-- End Banner -->

    <!-- Start Order Form -->
    <section class="ship-form-2">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-12">
                    <h3 class="mb-3 text-blue" style="font-size: 30px">{{ $store->shopify_name }}</h3>
                    <div class="card rounded border-0">
                        <div class="card-body rounded">
                            <div class="table-details mb-">
                                <span>Order Date: {{ date('m/d/y',strtotime($order->orderdate)) }}</span>
                            </div>
                            <div class="table-responsive">
                                <label>Select claimed items from order:</label>
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
                                            @if(strtolower($detail->title)!='guide shipping protection' && strtolower($detail->title)!='guide protection')
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

    <!-- Start Description -->
    <section class="description">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="tracking-num">
                            <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                            {{--<p class="sub_heading">Tracking Number</p>
                            <input type="text" name="cart_trackingnumber" id="cart_trackingnumber">--}}
                            <div class="alert-danger py-3 hidden"></div>
                            <center><button type="button" class="btn contact_btn btn-medium btn-green btn-rounded my-4" id="claim_form_button">Next </button></center>
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
            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0){
                $(".alert-danger").html("");
            }
        });
        $("#claim_form_button").on('click',function (e) {
            e.preventDefault();

            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0){
                $(".alert-danger").removeClass("hidden");
                $(".alert-danger").html("  Please select at least one item.");
                // cancel submit
                return false;
            }else{
                $(".alert-danger").html("");
               $("#claim_form").submit();
                return true;
            }

        })
    </script>
@endsection
