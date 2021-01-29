@extends("admin.layouts.app")
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Users
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Dropdown-->

            </div>
        </div>
        <div class="card-body">
            <form style="width: 100%" id="user" method="post" action="{{ route('admin.user_store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control required" tabindex="1" id="firstname" name="firstname" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control required" tabindex="3" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control required" tabindex="5" id="password" name="password" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label for="user_role">ser Role</label>
                            <select class="form-control required" id="user_role" tabindex="7" name="user_role">
                                <option value="1">Admin</option>
                                <option value="2">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control required" tabindex="2" id="lastname" name="lastname" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control required" tabindex="4" id="username" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control required" tabindex="6" id="confirm_password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="is_sale_rep">Sales Rep</label>
                            <input type="checkbox" class="checkbox checkbox-outline checkbox-success" tabindex="8" id="is_sale_rep" name="is_sale_rep">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
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
