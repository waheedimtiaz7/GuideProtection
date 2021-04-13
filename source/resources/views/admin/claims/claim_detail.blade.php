@extends("admin.layouts.app")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    .history_list{
        border:1px solid #0a1520;min-height: 200px;overflow-y: auto;padding-top:15px
    }
    table{
        font-size: small;
    }
</style>
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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Claim Detail</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.claims") }}" class="text-muted">Claims</a>
                            </li>

                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-muted">{{ $claim->id }}</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Card-->
                <form class="" id="update_claim">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Claim # {{ $claim->id }}
                                    <span class="d-block text-muted pt-2 font-size-sm">Showing All Claim Information</span>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                <a href="#" class="btn btn-primary font-weight-bolder" id="btn_previous">
                                    <span class="svg-icon svg-icon-md">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>Previous Claims ({{ count($previous_claims) }})
                                </a>
                                <!--end::Button-->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">

                                        {{ csrf_field() }}
                                    <div class="row mb-8">
                                        <div class="col-lg-2 mb-lg-0 mb-6">
                                            <label for="hold_until_date">Hold Until:</label>
                                            <input type="text" name="hold_until_date" id="hold_until_date" class="form-control" id="kt_datepicker_1" readonly="readonly" placeholder="Select date" value="{{ !empty($claim->hold_until_date)&& $claim->hold_until_date!=null?date('m/d/Y',strtotime($claim->hold_until_date)):date("m/d/Y") }}"/>
                                        </div>
                                        <div class="col-lg-2 mb-lg-0 mb-6">
                                            <label for="claim_status">Claim Status:</label>
                                            <select class="form-control " data-col-index="6" name="claim_status" id="claim_status">
                                                <option value="">Select</option>
                                                @foreach($claim_statuses as $claim_status)
                                                    <option {{ $claim->claim_status==$claim_status->value?"selected":"" }} value="{{ $claim_status->value }}">{{ $claim_status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-lg-0 mb-6">
                                            <label for="reorder_status">Reorder Status:</label>
                                            <select class="form-control " data-col-index="7" id="reorder_status" name="reorder_status">
                                                <option value="">Select</option>
                                                @foreach($reorder_statuses as $reorder_status)
                                                    <option {{ $claim->reorder_status==$reorder_status->value?"selected":"" }} value="{{ $reorder_status->value }}">{{ $reorder_status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 mb-lg-0 mb-6">
                                            <label for="claim_rep">Claim Rep:</label>
                                            <select class="form-control " data-col-index="0" name="claim_rep" id="claim_rep">
                                                <option value=""></option>
                                                @foreach($reps as $rep)
                                                    <option {{ $claim->claim_rep==$rep->id?"selected":"" }} value="{{ $rep->id }}">{{ $rep->firstname.' '.$rep->lastname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-lg-0 mb-6">
                                            <div class="form-group">
                                                <label for="escalate">Escalate:</label>
                                                <div class="checkbox-inline">
                                                    <label class="checkbox checkbox-lg checkbox-success">
                                                        <input type="checkbox" {{ $claim->is_escalated==1?"checked":""}} name="escalate" id="escalate" value="1">
                                                        <span></span>Enabled
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input name="claim_id" value="{{ $claim->id }}" type="hidden">

                                <div>
                                    <div class="row mb-8">
                                        <div class="col-lg-3 mb-lg-0 mb-6">
                                            <label><strong>Store:</strong> {{ isset($claim->shop->shopify_name)?$claim->shop->shopify_name:'' }}  <a href="#.">Launch</a> </label>
                                            <br/>
                                            <label><strong>Order:</strong> {{ $claim->cart_ordernumber }}  </label>
                                            <br/>
                                            <label><strong>Order Date:</strong> {{ date('m/d/Y',strtotime($claim->orderdate)) }}  </label>
                                            <br/>
                                            <label><strong>Customer Name:</strong> {{ $claim->customer_firstname." ".$claim->customer_lastname }}  </label>
                                            <br/>
                                            <label><strong>Customer Email:</strong> {{ $claim->customer_email }}  </label>
                                            <br/>
                                            <label><strong>Customer Phone:</strong> {{ $claim->customer_phone }}  </label>
                                        </div>
                                        <div class="col-lg-3 mb-lg-0 mb-6">
                                            <label><strong>Shipping:</strong> </label>
                                            <br/><br/>
                                            <label><strong>Address 1:</strong> {{ $claim->shipping_addresss_1 }}  </label>
                                            <br/>
                                            <label><strong>Address 2:</strong> {{ $claim->shipping_addresss_2 }}  </label>
                                            <br/>
                                            <label><strong>City, State, Zip:</strong> {{$claim->shipping_city.', '.$claim->shipping_state.', '.$claim->shipping_zip }}  </label>
                                            <br/>
                                            <label><strong>Country:</strong> {{ $claim->shipping_country }}  </label>
                                        </div>
                                        <div class="col-lg-3 mb-lg-0 mb-6">
                                            <label><strong>Shopify Tracking #:</strong> <a target="_blank" href="{{ $claim->cart_tracking_url }}">{{ $claim->cart_trackingnumber }} </a></label>
                                            <div class="form-group row ">
                                                <label class="col-lg-4 col-form-label " for="gp_reorder_trackno">GP Tracking #:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" class="form-control" placeholder=""  name="gp_reorder_trackno" id="gp_reorder_trackno" value="{{ $claim->gp_reorder_trackno }}"/>
                                                </div>
                                                <div class="col-lg-3 ">

                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="col-lg-4 col-form-label " for="reorder_trackingnumber">Reorder Tk #:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" class="form-control" placeholder="" name="reorder_trackingnumber" id="reorder_trackingnumber" value="{{ $claim->reorder_trackingnumber }}"/>
                                                </div>
                                                <div class="col-lg-3 ">

                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="col-lg-4 col-form-label " for="reorder_cartnumber">Reorder #:</label>
                                                <div class="col-lg-5">
                                                    <input type="text" class="form-control" placeholder="" name="reorder_cartnumber" id="reorder_cartnumber" value="{{ $claim->reorder_cartnumber }}"/>
                                                </div>
                                                <div class="col-lg-3 ">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mb-lg-0 mb-6">
                                            <div class="previous_claims" style="display: none;">
                                                <!--begin: Datatable-->
                                                <div class="table-responsive">
                                                    <table class="table table-striped " >
                                                        <thead class="thead-little-dark">
                                                            <tr>
                                                                <th>Claim ID</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($previous_claims as $previous_claim )
                                                                <tr>
                                                                    <td><a href="{{ route('admin.claim_detail',[$previous_claim->id]) }}" target="_blank">{{ $previous_claim->id }}</a></td>
                                                                    <td>{{ date('m/d/Y',strtotime($previous_claim->created_at)) }}</td>
                                                                    <td>{{ $previous_claim->incidentType->title }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped " >
                                            <thead class="thead-little-dark">
                                            <tr>
                                                <th>Qty</th>
                                                <th>SKU</th>
                                                <th>Description</th>
                                                <th>Selected for Claim</th>
                                                <th>Amount</th>
                                                <th>Variant ID Link</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total=0;
                                            $all_links='';
                                            ?>
                                                @foreach($claim->claim_detail as $k=>$claim_detail )
                                                    <tr>
                                                        <td>{{ $claim_detail->quantity }}</td>
                                                        <td><?php
                                                            $product=\App\Models\OrderDetail::where('cart_variantid',$claim_detail->variantid)->first();
                                                            echo $product->sku;
                                                            ?>
                                                        </td>
                                                        <?php
                                                        $total=$total+($product->final_unit_price*$claim_detail->quantity);
                                                        $all_links.=$claim_detail->variantid.":".$claim_detail->quantity;
                                                        if($k+1!=count($claim->claim_detail)){
                                                            $all_links.=',';
                                                        }
                                                        ?>

                                                        <td>{{ $product->cart_name }}</td>
                                                        <td><input type="checkbox" checked="checked" ></td>
                                                        <td>{{ $product->final_unit_price }}</td>
                                                        <td><a target="_new" href="http://{{ $claim->store_id }}/cart/{{$claim_detail->variantid}}:{{$claim_detail->quantity}}">open</a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row ">
                                        <div class="col-lg-11 mb-lg-0 mb-6">
                                            <label><strong>Issue:</strong> {{ $claim->incidentType->title }} </label>
                                            <br/>
                                            <label><strong>Issue Detail:</strong> {{ $claim->incident_description }}</label>
                                            <br/>
                                            <a href="http://{{ $claim->store_id }}/cart/{{$all_links}}" target="_blank" class="btn btn-light-info">Reorder</a>
                                        </div>
                                        <div class="col-lg-1 mb-lg-0 mb-6 text-right">
                                            <label for="total">Approved Claim Amount:</label>
                                            <input type="text" class="form-control text-right" name="total" id="total" value="{{ $claim->claim_approve_amount }}"  />
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-lg-7 mb-lg-0 mb-6">
                                            <label for="notes">Notes:</label>
                                            <textarea class="form-control" rows="15" name="notes" id="notes">{{ $claim->notes }} </textarea>
                                        </div>
                                        <div class="col-lg-5 mb-lg-0 mb-6">
                                            <label>Files:</label>
                                            <!--begin: Datatable-->
                                            <div class="table-responsive">
                                                <table class="table table-striped ">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="files_list">
                                                    @foreach($claim->files as $file )
                                                        <tr>
                                                            <td>{{ $file->filename }}</td>
                                                            <td>{{ $file->description }}</td>
                                                            <td>{{ date("m/d/Y",strtotime($file->created_at)) }}</td>
                                                            <td>
                                                                <a href="{{ asset($file->path) }}" target="_blank">View</a>
                                                            <a href="{{ url('admin/delete-claim-file/'.$file->id) }}" target="_blank">delete</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row mt-8">
                                                <div class="col-lg-12 text-right">
                                                    <button class="btn btn-primary btn-primary--icon" type="button"  data-toggle="modal" data-target="#add_files">
                                                        <span>
                                                            <i class="la la-plus"></i>
                                                            <span>Add File</span>
                                                        </span>
                                                    </button>&#160;&#160;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="row mt-8">
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary btn-primary--icon" type="button" onclick="saveForm(0)">
                                                    <span>
                                                        <i class="la la-save"></i>
                                                        <span>Save</span>
                                                    </span>
                                                </button>&#160;&#160;
                                                <button class="btn btn-secondary btn-secondary--icon" type="button" onclick="saveForm(1)">
                                                    <span>
                                                        <i class="la la-save"></i>
                                                        <span>Save & Exit</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div>&nbsp;</div>
                <!-- card start -->
                <div class="card card-custom">
                    <div class="row mt-15 card-body">
                        <div class="col-lg-7 mb-lg-0 mb-6">
                            <form id="send_mail">
                                {{ csrf_field() }}
                                <input class="form-control" type="hidden" name="mail_claim_id" id="mail_claim_id" value="{{ $claim->id }}">
                                <input class="form-control" type="hidden" name="mail_template_id" id="mail_template_id">
                                <div>
                                    <label for="to">To:</label>
                                    <input class="form-control mb-8" name="to" id="to" type="email" value="{{ $claim->customer_email }}" />
                                </div>
                                <div>
                                    <label for="mail_subject">Subject:</label>
                                    <input type="text" class="form-control mb-8" name="mail_subject" id="mail_subject"  />
                                </div>

                                <div>
                                    <label for="mail_detail"></label>
                                    <textarea class="form-control" rows="6" name="mail_detail" id="mail_detail"> </textarea>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-lg-12 ">
                                        <button class="btn btn-primary btn-primary--icon"  type="button" onclick="sendMail()">
                                            <span>
                                                <i class="la la-send"></i>
                                                <span>Send</span>
                                            </span>
                                        </button>&#160;&#160;
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-5 mb-lg-0 mb-6">
                            <div class="col-6">
                                <p>Emails</p>
                                <button class="btn btn-primary w-250px" onclick="getMailDetail(7)">Send Denial Notifications</button><br><br>
                                <button class="btn btn-primary w-250px" onclick="getMailDetail(8)">Send Reorder Notifications</button><br><br>
                                <button class="btn btn-primary w-250px" onclick="getMailDetail(9)">Send Tracking Number</button><br><br>
                                <button class="btn btn-primary w-250px" onclick="getMailDetail(10)">Everything's good?</button><br><br>
                                <br>
                                <p>Other Processes</p>
                                <div><button {{ Auth::user()->user_role==1?"":"disabled='disabled'" }} class="btn btn-dark w-250px" onclick="refundToStore()">Post refund to store</button><span class="refundText">{{ !empty($claim->payout_batch_id)?"Claim has been refunded to store":"" }}</span></div><br>
                                <div><button {{ Auth::user()->user_role!=1||$claim->discount_or_gift_status==1?"disabled='disabled'":"" }} class="btn btn-dark w-250px" onclick="getDiscountCode()">Refund and create DC</button></div><br>
                                <button {{ Auth::user()->user_role!=1||$claim->discount_or_gift_status==1?"disabled='disabled'":"" }} {{ $claim->discount_or_gift_status==1?"disabled='disabled'":"" }} class="btn btn-dark w-250px" onclick="getGiftCard()">Refund and create GC</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div>&nbsp;</div>
                <!-- card start -->
                <div class="card card-custom">
                    <div class="row mt-15 card-body">
                        <div class="col-lg-7 ">
                            <h3 class="card-label mb-5">Claim History</h3>
                            <!--begin: Datatable-->
                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead class="thead-little-dark">
                                    <tr>
                                        <th>Detail</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($history as $h )
                                            <tr>
                                                <td>{{ $h->detail }}</td>
                                                <td>{{ date('m/d/Y',strtotime($h->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_files" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form enctype="multipart/form-data" id="file_form">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Files</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subject">Select File</label>
                            <input type="file" name="file" id="file"  required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                            <input type="hidden" id="claim_id" name="claim_id" value="{{ $claim->id }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success float-right" type="submit" id="file_submit">Submit</button>
                        <button class="btn btn-default" type="button" onclick="resetForm()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $("#btn_previous").click(function(){
            $(".previous_claims").toggle(500);
        });
    </script>
    <script src="{{ asset("/") }}assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
    <!--end::Page Scripts-->

    <script>
        function refundToStore() {
            var data={"shop_id":{{ $claim->shop_id }},"claim_id":{{ $claim->id }},"_token":"{{ csrf_token() }}","amount":$("#total").val()};
            $.ajax({
                url:"{{ route('paymentWithPaypal') }}",
                type: 'POST',
                data: data,
                success: function(data) {
                    if(data.success){
                        $(".refundText").text("Claim has been refunded to store");
                        Swal.fire({
                            text:data.message ,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }else{
                        Swal.fire({
                            text:data.message ,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                }
            });
        }
        function resetForm(){
            document.getElementById("file_form").reset();
            $("#add_files").modal("hide");
        }
        $("form#file_form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{ route('admin.claim_store_file') }}",
                type: 'POST',
                data: formData,
                success: function(data) {
                    if(data.success){
                        resetForm();
                        var html='';
                        var base="{{ asset('/') }}";
                        $.each(data.files,function (index,value) {
                            var date=new Date(value.created_at)
                            html+='<tr>';
                            html+='<td>'+value.filename+'</td>';
                            if(value.description!=null && value.description!==''){
                                html+='<td>'+value.description+'</td>';
                            }else{
                                html+='<td></td>';
                            }
                            html+='<td>'+date.getMonth()+1+'/'+date.getDate()+'/'+date.getFullYear()+'</td>';
                            html+='<td><a href="'+base+'/'+ value.path +'" target="_blank">View</a>  ' +
                                '<a href="{{ url('admin/delete-claim-file/') }}/'+ value.id +'" target="_blank">delete</a></td>';
                            html+='</tr>';
                        })
                        $("#files_list").html(html)
                    }else{
                        Swal.fire({
                            text:data.message ,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        function saveForm(type){

            var formData = new FormData( $("#update_claim")[0]);
            $.ajax({
                url: "{{ route('admin.update_claim') }}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.success) {
                        if(type===0){
                            Swal.fire({
                                text: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    location.reload();
                                } else if (result.isDenied) {
                                    location.reload();
                                }
                            });

                        }else{
                            Swal.fire({
                                text: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.href='{{ route('admin.claims') }}';
                                } else if (result.isDenied) {
                                    window.location.href='{{ route('admin.claims') }}';
                                }
                            });

                        }
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
        function getMailDetail(id) {
            $.ajax({
                url:"{{ url('admin/get-mail-detail') }}"+"/"+id,
                type:"get",
                success:function (data) {
                    if(data.success){
                        $("#mail_subject").val(data.template.subject);
                        $("#mail_template_id").val(data.template.id);
                        $("#mail_detail").val(data.detail);
                    }
                }
            })
        }
       function sendMail() {
            $.ajax({
                url:"{{ route('send_mail') }}",
                data:$("#send_mail").serialize(),
                type:"post",
                success:function (data) {
                    if(data.success){
                        $("#mail_subject").val("");
                        $("#mail_template_id").val("");
                        $("#mail_detail").val("");
                        Swal.fire({
                            text: "Mail sent successfully",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }else{
                        Swal.fire({
                            text: data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                }
            })
       }
        function getDiscountCode() {
            Swal.fire({
                text: "Message should read: Are you sure?",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Confirm!",
                cancelButtonText: 'Cancel',
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                    cancelButton:"btn font-weight-bold btn-light-danger"
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url:"https://guideprotection.com/protectit/core/ajax_discount_rules",
                        type:"post",
                        data:{shop_id:"{{ $claim->shop_id }}"},
                        success:function (data) {
                            if(data.Flag===1){
                                $.ajax({
                                    url:"{{ route('admin.save_discount_code') }}",
                                    type:"post",
                                    data:{shop_id:"{{ $claim->shop_id }}",order_id:"{{ $claim->order_id }}",DiscountCode:data.DiscountCode,_token:"{{ csrf_token() }}"},
                                    success:function (data) {
                                        if(data.success){
                                            location.reload();
                                        }else{

                                        }

                                    }
                                })
                            }else{
                                Swal.fire({
                                    text:data.Message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then((result) => {

                                })
                            }
                        }
                    })
                } else if (result.isDenied) {
                }
            });

        }
        function getGiftCard() {
            Swal.fire({
                text: "Please make sure price price rules are correct before posting to shopify.",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Confirm!",
                cancelButtonText: 'Cancel',
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                    cancelButton:"btn font-weight-bold btn-light-danger"
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url:"https://guideprotection.com/protectit/core/ajax_gift_cards",
                        type:"post",
                        data:{shop_id:"{{ $claim->shop_id }}"},
                        success:function (data) {
                            if(data.Flag===1){
                                    $.ajax({
                                        url:"{{ route('admin.save_gift_card') }}",
                                        type:"post",
                                        data:{shop_id:"{{ $claim->shop_id }}",order_id:"{{ $claim->order_id }}",GiftCardNo:data.GiftCardNo,_token:"{{ csrf_token() }}"},
                                        success:function (data) {
                                            location.reload();
                                        }
                                    })
                            }else{
                                Swal.fire({
                                    text:data.Message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then((result) => {

                                })
                            }
                        }
                    })
                } else if (result.isDenied) {
                }
            });

        }
    </script>

@endsection
