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
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <div class="mt-15">
                <form id="update_claim">
                    {{ csrf_field() }}
                    <input name="claim_id" value="{{ $claim->id }}" type="hidden">
                <div class="row">
                    <div class="col-3">
                        <h1>Claim Detail</h1>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="hold_until_date">Hold Until</label>
                                    <input class="form-control" name="hold_until_date" id="hold_until_date" value="{{ !empty(date('m/d/Y',strtotime($claim->hold_until_date)))&& $claim->hold_until_date!=null?date('m/d/Y',strtotime($claim->hold_until_date)):date("m/d/Y") }}">
                                </div>
                                <div class="form-group">
                                    <label><input name="escalate" id="escalate" type="checkbox"> Escalate</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="claim_status">Claim Status</label>
                                    <select class="form-control" name="claim_status" id="claim_status">
                                        @foreach($claim_statuses as $claim_status)
                                            <option {{ $claim->claim_status==$claim_status->value?"selected":"" }} value="{{ $claim_status->value }}">{{ $claim_status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="reorder_status">Reorder Status</label>
                                    <select class="form-control" name="reorder_status" id="reorder_status">
                                        @foreach($reorder_statuses as $reorder_status)
                                            <option {{ $claim->reorder_status==$reorder_status->value?"selected":"" }} value="{{ $reorder_status->value }}">{{ $reorder_status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="claim_rep">Claims Rep</label>
                                    <select class="form-control" name="claim_rep" id="claim_rep">
                                        <option value=""></option>
                                        @foreach($reps as $rep)
                                            <option {{ $claim->claim_rep==$rep->id?"selected":"" }} value="{{ $rep->id }}">{{ $rep->firstname.' '.$rep->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <h5>Previous Claims</h5>
                                <table class="table table-bordered font-size-lg">
                                    <thead>
                                    <tr>
                                        <th>Claim ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($previous_claims as $previous_claim )
                                        <tr>
                                            <td><a href="{{ route('admin.claim_detail',[$previous_claim->store_ordernumber]) }}" target="_blank">{{ $previous_claim->id }}</a></td>
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
                <div class="row">
                    <div class="col-12 col-md-4">
                        <p></p>
                        <div class="row"><span class="col-5">Store</span><span class="col-7">{{ isset($claim->shop->shopify_name)?$claim->shop->shopify_name:'' }}</span></div>
                        <div class="row"><span class="col-5">Order Number</span><span class="col-7">{{ $claim->store_ordernumber }}</span></div>
                        <div class="row"><span class="col-5">Order Date</span><span class="col-7">{{ date('m/d/Y',strtotime($claim->orderdate)) }}</span></div>
                        <div class="row"><span class="col-5">Customer Name</span><span class="col-7">{{ $claim->customer_lastname }}</span></div>
                        <div class="row"><span class="col-5">Customer Email</span><span class="col-7">{{ $claim->customer_email }}</span></div>
                        <div class="row"><span class="col-5">Customer Phone</span><span class="col-7">{{ $claim->customer_phone }}</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <p>Shipping</p>
                        <div class="row"><span class="col-5">Address 1</span><span class="col-7">{{ $claim->shipping_addresss_1 }}</span></div>
                        <div class="row"><span class="col-5">Address 2</span><span class="col-7">{{ $claim->shipping_addresss_2 }}</span></div>
                        <div class="row"><span class="col-5">City, State Zip</span><span class="col-7">{{$claim->shipping_city.', '.$claim->shipping_state.', '.$claim->shipping_zip }}</span></div>
                        <div class="row"><span class="col-5">Country</span><span class="col-7">{{ $claim->shipping_country }}</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <p></p>
                        <div class="row"><span class="col-5">Shopify Tracking #</span><span class="col-7">{{ $claim->cart_trackingnumber }}</span></div>
                        <div class="row"><span class="col-5">GP Tracking #</span><span class="col-7"><input name="gp_reorder_trackno"></span></div>
                        <div class="row"><span class="col-5">Reorder TK #</span><span class="col-7"><input name="reorder_trackingnumber"></span></div>
                        <div class="row"><span class="col-5">Reorder #</span><span class="col-7"><input name="reorder_cartnumber"></span></div>
                    </div>

                </div>
                <div class="row mt-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Qty</th>
                            <th>SKU</th>
                            <th>Description</th>
                            <th>Selected for Claim</th>
                            <th>Variant ID link</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($claim->claim_detail as $claim_detail )
                            <tr>
                                <td>{{ $claim_detail->quantity }}</td>
                                <td><?php
                                        $product=\App\Models\OrderDetail::where('cart_variantid',$claim_detail->variantid)->first();
                                        echo $product->sku;
                                    ?>
                                </td>
                                <td>{{ $product->cart_name }}</td>
                                <td>edit</td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-12"><p>Issue: {{ $claim->incident_type }}</p></div>
                    <div class="col-12"><p>Issue Detail: {{ $claim->incident_description }}</p></div>
                </div>
                <div class="row" style="margin-bottom:12px">
                    <div class="col-6">
                       <div class="form-group">
                           <label for="notes">Notes</label>
                           <textarea style="min-height:210px" class="form-control" name="notes" id="notes" placeholder="Notes"></textarea>
                       </div>
                   </div>
                    <div class="col-6">
                       <div class="form-group">
                           <label for="notes">Files</label>
                           <table class="table table-bordered">
                               <thead>
                                   <tr>
                                       <th>Filename</th>
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
                                               <a href="{{ asset($file->path) }}" target="_blank">View</a></td>
                                           <a href="{{ url('admin/delete-claim-file/'.$file->id) }}" target="_blank">delete</a>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                           <button class="btn btn-success float-right" type="button"  data-toggle="modal" data-target="#add_files">Add File</button>
                       </div>
                   </div>
                </div>
                    <div class="clearfix"></div>
                <button class="btn btn-light-primary float-right" type="button" onclick="saveForm(0)">Save</button>
                <button class="btn btn-secondary float-right" type="button" onclick="saveForm(1)">Save & Exit</button>
                </form>
                <div class="clearfix"></div>
                <div class="row" style="margin-top:15px">
                    <div class="col-6">
                        <form id="send_mail">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="to">To</label>
                                <input class="form-control" name="to" id="to" type="email" value="{{ $claim->customer_email }}">
                            </div>
                            <input class="form-control" type="hidden" name="mail_claim_id" id="mail_claim_id" value="{{ $claim->id }}">
                            <input class="form-control" type="hidden" name="mail_template_id" id="mail_template_id">
                            <div class="form-group">
                                <label for="mail_subject">Subject</label>
                                <input class="form-control" name="mail_subject" id="mail_subject">
                            </div>
                            <div class="form-group">
                                <label for="mail_detail">Message</label>
                                <textarea style="min-height:210px" class="form-control" name="mail_detail" id="mail_detail" placeholder="Message"></textarea>
                            </div>
                            <button type="button" onclick="sendMail()" class="btn btn-success float-right">Send</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <p>Emails</p>
                        <button class="btn btn-primary w-250px" onclick="getMailDetail(7)">Send Denial Notifications</button><br><br>
                        <button class="btn btn-primary w-250px" onclick="getMailDetail(8)">Send Reorder Notifications</button><br><br>
                        <button class="btn btn-primary w-250px" onclick="getMailDetail(9)">Send Tracking Number</button><br><br>
                        <button class="btn btn-primary w-250px" onclick="getMailDetail(10)">Everything's good?</button><br><br>
                        <br>
                        <p>Other Processes</p>
                        <button class="btn btn-dark w-250px">Post refund to store</button><br><br>
                        <button class="btn btn-dark w-250px">Refund and create DC</button>
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <h6>Claim History</h6>
                    <div class="col-12 history_list">
                        <ol>
                            @foreach($history as $h)
                                <li class="pt-3">{{ $h->detail }}</li>
                            @endforeach
                        </ol>
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
@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#hold_until_date" ).datepicker();
        } );
    </script>
    <script>
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
                            html+='<td>'+value.description+'</td>';
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
                        $("#mail_detail").val(data.template.detail);
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
    </script>

@endsection
