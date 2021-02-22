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
                                        <span class="active-step">03</span>
                                    </li>
                                    <li class="whitecolor wow fadeIn" data-wow-delay="600ms">
                                        <span class="active-step">04</span>
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
    <form id="claim_form_post">
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
        <section class="dropdown pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="sub_heading">What Happened? (Please note that we do not cover manufacturing defects)</p>
                            @foreach($incident_types as $incident_type)
                            <label><input class="radio-dark" type="radio" name="incident_type" value="{{ $incident_type->value }}">&nbsp; {{ $incident_type->title }} </label>
                            @endforeach

                    </div>
                </div>
            </div>
        </section>
        @foreach($items as $k=>$item)
                    <input name="item[]" type="hidden" value="{{ $item }}">
                    <input name="qty[]" type="hidden"  value="{{ $quantity[$k] }}">
        @endforeach
        <section class="description">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="sub_heading">Description of incident</p>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Message" id="incident_description" name="incident_description"></textarea>
                            <div class="tracking-num py-3">
                                <input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
                                {{--<p class="sub_heading">Tracking Number</p>
                                <input type="text" name="cart_trackingnumber" id="cart_trackingnumber">--}}
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
            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0){
                $(".alert-danger").html("");
            }
        });
        $("#claim_form_post").on('submit',function (e) {
            e.preventDefault();
            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0){
                $(".alert-danger").removeClass("hidden");
                $(".alert-danger").html("  Please select at least one item and include a description.");
                // cancel submit
                return false;
            }else{
                $(".alert-danger").html("");
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
