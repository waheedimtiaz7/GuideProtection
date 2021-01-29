@extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="mt-37">
                <div class="row">
                    <div class="col-12">
                        <h1>Guide Shipping Protection</h1>
                        <h1 class="mt-10">Claim Form</h1>
                    </div>
                    <div class="col-12 px-18 mt-10">
                        <p>Having a Problem with Delivery? If you purchased Guide Shipping protection during checkout we can replace your order free of charge</p>
                        <p>Please fill out the following</p>
                    </div>
                    <div class="col-12 mt-10">
                        <h1>Find Your Order</h1>
                        <form class="px-18 mt-10" id="check_order">
                            <div class="form-group">
                                <label for="email" class="d-inline-flex w-100px">Order Email</label>
                                <div class="control d-inline-flex">
                                    <input class="form-control" name="email" id="email" type="email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order_number" class="d-inline-flex w-100px"> Order #
                                </label>
                                <div class="control d-inline-flex">
                                    <input class="form-control" name="order_number" id="order_number" type="text"/>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-info">Continue</button>
                        </form>
                    </div>
                    <p class="mt-30">Contact Us: <a href="mailto:support@guideprotection.com">support@guideprotection.com</a></p>
                </div>
            </div>
        </div>
    @endsection
@section('script')
    <script>
        $("#check_order").on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                url:"{{ route('check_order') }}",
                data:$(this).serialize(),
                type:"post",
                success:function (data) {
                    if(data.success){
                        window.location.href="{{ url("file-claim") }}"+"/"+$("#order_number").val()
                    }else{
                        alert(data.message)
                    }
                }
            })
        })

    </script>
@endsection
