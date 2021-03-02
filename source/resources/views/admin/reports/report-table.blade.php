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
                        <div class="col-md-12">

                            <div class="select-report-btn text-right " style="margin-bottom:10px;">

                                <span class="pull-left">*First 250 records displayed.  Export to Excel for complete list</span>
                                <button type="button" class="btn btn-primary" href="" onclick="javascript:history.back()">Modify Criteria</button>
                                <a href="<?php echo url('/admin/reports/');?>" type="button"  class="btn btn-primary">Start Over</a>
                                <button type="button" id="export_excel" class="btn btn-primary">Export to Excel</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="ilgk-table"  class="table-responsive col-lg-12 ">
                                <?php if(isset($report_table)){echo $report_table;}  ?>
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

    $('#clear').click(function(){
        window.location.href = "<?php echo url('/admin/reports/')?>";
    });

    $('#export_excel').click(function(){
        var query = $('#query').val();
        if(query != ''){
            $.ajax({
                type: 'POST',
                async: false,
                url: '<?php echo url('/admin/reports/'); ?>/set_report_session_value/',
                data: {
                    "_token": "{{ csrf_token() }}",
                    report_query: query
                },
                success: function () {
                    window.location.href = "<?php echo url('/admin/reports/')?>/generate_report_csv";
                }
            });
        }else{
            alert('Please enter the query.');
        }
    });
</script>
@endsection