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
                <div class="header-right" style="float: right">
                    <a class="btn btn-dark btn-xs" href="{{ route("admin.user_create") }}">Add New</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-checkable" id="kt_datatable">
                <thead>
                <tr>
                    <th>Firsname</th>
                    <th>Lastname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>System Role</th>
                    <th>Sales Rep</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_role==1?'Admin':'Staff' }}</td>
                            <td>@if($user->is_sale_rep==1)
                                    <input type="checkbox" disabled="disabled" checked>
                                @else
                                    <input type="checkbox" disabled="disabled">
                                @endif
                            </td>
                            <td>{{ $user->status==1?'Active':'Disabled' }}</td>
                            <td><a href="{{ route('admin.user_edit',[$user->id]) }}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

@endsection
