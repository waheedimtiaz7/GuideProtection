@extends('layouts.app')
@section('content')
<section class="ship-form-1">
    <div class="row">
        <div class="col-sm-12 col-lg-6 d-flex justify-content-center align-items-center">
            <div class="right-content">

                <!-- Logo -->
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="logo_img">
                            <img src="{{ asset("assets") }}/img/logo.png" alt="logo image">
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex justify-content-center justify-content-md-end">
                        <!-- WOrk Process-->
                        <div id="our-process">
                            <ul class="process-wrapp">
                                <li class="whitecolor wow fadeIn" data-wow-delay="300ms">
                                    <span class="active-step">01</span>
                                </li>
                                <li class="whitecolor wow fadeIn" data-wow-delay="400ms">
                                    <span class="pro-step">02</span>
                                </li>
                                <li class="whitecolor wow fadeIn">
                                    <span class="pro-step">03</span>
                                </li>
                            </ul>
                        </div>
                        <!--WOrk Process ends-->
                    </div>
                </div>

                <!-- Text -->
                <h2>Claim Form</h2>
                <p class="sub_heading">Having a problem with delivery? If you purchased Guide Shipping Protection during checkout, we can replace your order free of charge.</p>

                <!-- Login Form -->
                <form class="contact-form" id="contact-form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <h4 class="text-left my-4">Find your order</h4>
                            <div class="alert-danger py-3 hidden mb-5">Please provide the missing fields</div>
                            <div class="form-group">
                                <input class="form-control px-1" name="email" id="email" type="email" placeholder="Order Email" required="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <input class="form-control px-1" name="order_number" id="order_number" type="text" placeholder="Order #" required="">
                            </div>
                        </div>
                        <div class="col-sm-12 text-left">
                            {{ csrf_field() }}
                            <button type="submit" class="btn contact_btn btn-large btn-blue btn-rounded my-4">Continue</button>
                        </div>
                    </div>
                </form>
                <div class="support-link">
                    <h5>Contact us: <a href="#.">support@guideprotection.com</a></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-6 p-0">
            <div class="img-area">
                <div id="carouselExampleControls" class="carousel slide carousal-fade" data-ride="carousel">
                    <div class="carousel-inner ml-lg-10 ">
                        <div class="carousel-item active">
                            <img src="{{ asset("assets") }}/img/form-img1.jpg" class="d-block w-100 h-100" alt=" ">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@section('script')
    <script>
        $("#contact-form-data").on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                url:"{{ route('check_order') }}",
                data:$(this).serialize(),
                type:"post",
                success:function (data) {
                    if(data.success){
                        window.location.href="{{ url("file-claim") }}"+"/"+data.order.id
                    }else{
                        $(".alert-danger").removeClass("hidden");
                        $(".alert-danger").html(data.message);
                    }
                }
            })
        });
    </script>
@endsection