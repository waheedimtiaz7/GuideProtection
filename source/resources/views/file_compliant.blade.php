@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-37">
            <form id="claim_form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12">
                        <h1>Guide Shipping Protection</h1>
                        <h1 class="mt-10">Claim Form</h1>
                    </div>
                    <div class="col-12 mt-18">
                        <label class="font-weight-bold">Store Name</label>
                        <label class="float-right font-weight-bold">Order date: {{ date('m/d/y',strtotime($order->orderdate)) }} </label>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Claimed Items</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_detail as $k=>$detail)
                                    @if($detail->title!='Guide Protection' && $detail->title!='Guide protection')
                                        <tr>
                                            <td><input name="item[]" type="checkbox" class="checkbox-dark item" value="{{ $detail->id }}"></td>
                                            <td><input name="qty[]" id="qty_{{ $detail->id }}" disabled="disabled"  value="{{ $detail->qty }}"></td>
                                            <td>{{ $detail->title }}</td>
                                            <td>{{ $detail->sku }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-8 mb-10">
                            <div class="form-group">
                                <label for="incident_type">What Happened? (Please note that we do not cover manufacturing defects)</label><br>
                                <select name="incident_type" id="incident_type" class="form-control-sm" required="required">
                                    <option value=""></option>
                                    @foreach($incident_types as $incident_type)
                                        <option value="{{ $incident_type->value }}">{{ $incident_type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="incident_description">Description of incident</label><br>
                                <textarea name="incident_description" id="incident_description" class="form-control" required="required"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="cart_trackingnumber">Tracking number (if available)</label><br>
                                <input name="cart_trackingnumber" id="cart_trackingnumber" class="form-control-sm">
                            </div>
                            <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Submit</button>
                            </div>
                            <p class="mt-5">Note that items can only be re-shipped to the original address </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.item').change(function() {
            if(this.checked) {
                console.log($(this).val())
              $("#qty_"+$(this).val()).removeAttr('disabled')
            }else{
                $("#qty_"+$(this).val()).attr('disabled','disabled')
            }
        });
        $("#claim_form").on('submit',function (e) {
            e.preventDefault();
            var fields = $("input[name='item[]']").serializeArray();
            if (fields.length === 0)
            {
                alert('nothing selected');
                // cancel submit
                return false;
            }else{
                console.log(fields)
            }
            $.ajax({
                url:"{{ url('submit-claim-form') }}",
                data:$(this).serialize(),
                type:"post",
                success:function (data) {
                    if(data.success){
                        window.location.href="{{ url("success-page") }}"
                    }else{
                        alert("Order not found. If you think you'r receiving this by mistake, please contact your store's customer service.")
                    }
                }
            })
        })
    </script>
@endsection
