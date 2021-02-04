@extends("admin.layouts.app")
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">User</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route("admin.users") }}" class="text-muted">Users</a>
                            </li>

                            <li class="breadcrumb-item text-muted">
                                <a href="#" class="text-muted">Update</a>
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
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Update User
                                <span class="d-block text-muted pt-2 font-size-sm">Update user info</span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form style="width: 100%" id="user" method="post" action="{{ route('admin.user_update') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control required" tabindex="1" id="firstname" name="firstname" value="{{ $user->firstname }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control required" tabindex="3" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control required" tabindex="5" id="username" name="username" value="{{ $user->username }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" tabindex="7" id="password" name="password" placeholder="Enter Password">
                                    </div>

                                    <div class="form-group">
                                        <label for="is_sale_rep">Sales Rep</label>
                                        <input type="checkbox" {{ $user->is_sale_rep==1?"checked":"" }} tabindex="9" class="checkbox checkbox-outline checkbox-success" id="is_sale_rep" name="is_sale_rep">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control required" tabindex="2" id="lastname" name="lastname" value="{{ $user->lastname }}">
                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_role">User Role</label>
                                        <select class="form-control" id="user_role" tabindex="4" name="user_role">
                                            <option {{ $user->user_role==1?"selected":"" }} value="1">Admin</option>
                                            <option {{ $user->user_role==2?"selected":"" }} value="2">Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" tabindex="6" name="status">
                                            <option {{ $user->status==1?"selected":"" }} value="1">Active</option>
                                            <option {{ $user->status==0?"selected":"" }} value="2">Disabled</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" tabindex="8" id="confirm_password" name="confirm_password" placeholder="confirmvpassword">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="float-right">
                                    <a href="{{ route('admin.users') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

