@extends("admin.layouts.app")
@section('content')<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Reports</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route("admin.users") }}" class="text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Reports</a>
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right mb-20 pr-15">
                            <button type="button" class="btn btn-primary">Run</button>
                            <a href="#" id="export_excel" class="btn btn-primary">Export to Excel</a>
                        </div>
                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="row">
                                    <div class="col-sm-12 paddingleft">
                                        <div class="setting-section">
                                            <h5>Select Reports <span class="run-report" id="execute">Run</span></h5>
                                            <div class="documenttype-section">
                                                <select id="report-list" class="select-documenttype new-type form-control" multiple="">
                                                    <?php
                                                    if($reports){
                                                        foreach ($reports as $report){
                                                            ?>
                                                            <option value="<?php echo $report->ID?>"><?php echo $report->ReportName?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 paddingleftright text-right mb-20">
                                <button type="button" class="btn btn-primary">Run</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-12 paddingleftright table-newscreen">

                                    <div id="ilgk-table"></div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script type="text/javascript">
        $('#export_excel').click(function(){
            var id = $('#report-list').val();
            if(id != ''){
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '<?php echo url('/admin/reports/'); ?>reports/set_front_report_session_value/',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function () {
                        window.location.href = "<?php echo url('/admin/reports/')?>reports/generate_report_csv";
                    }
                });
            }else{
                alert('Please enter the query.');
            }
        });
        $('#execute').click(function(){
            var id = $('#report-list').val();
//            alert(query);
            $.ajax({
                type: 'POST',
                async: false,
                url: '<?php echo url('/admin/reports/'); ?>reports/get_front_report/',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (data) {
                    $('#ilgk-table').html(data);
                    $('.datatable').DataTable({
                        "scrollY": "520px",
                        "scrollX": "520px",
                        "scrollCollapse": true,
                        "paging": false,
                        "searching": false,
                    });
                }
            });
        });

        $(document).ready(function () {
            $('.datatable').DataTable({
                "scrollY": "520px",
                "scrollX": "520px",
                "scrollCollapse": true,
                "paging": false,
                "searching": false,
            });
        });

    </script>
    @endsection