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
                                <a href="#" class="text-muted">Create</a>
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
                            <h3 class="card-label">Create User
                                <span class="d-block text-muted pt-2 font-size-sm">Fill user info</span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form style="width: 100%" id="user" method="post" action="{{ route('admin.user_store') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control required" autocomplete="false" tabindex="1" id="firstname" name="firstname" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" autocomplete="false" class="form-control required" tabindex="3" id="email" name="email" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control required" autocomplete="false" tabindex="5" id="password" name="password" placeholder="Enter Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="is_sale_rep">Sales Rep</label>
                                        <input type="checkbox" class="checkbox checkbox-outline checkbox-success" tabindex="7" id="is_sale_rep" name="is_sale_rep">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control required" autocomplete="false" tabindex="2" id="lastname" name="lastname" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_role">User Role</label>
                                        <select class="form-control required" id="user_role" tabindex="4" name="user_role">
                                            <option value="1">Admin</option>
                                            <option value="2">Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control required" autocomplete="false" tabindex="6" id="confirm_password" placeholder="Confirm Password">
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
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
