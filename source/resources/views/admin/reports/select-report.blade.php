
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
                    <?php

                    if($report){
                        $report_name = $report->ReportName;
                        $report_id = $report->id;
                        $query = $report->Query;
                        $QueryForExport = $report->QueryForExport;
                        $param1 = $report->param1data;
                        $param2 = $report->param2data;
                        $param3 = $report->param3data;
                        $param4 = $report->param4data;
                        $param5 = $report->param5data;
                        $param1option = $report->param1type;
                        $param2option = $report->param2type;
                        $param3option = $report->param3type;
                        $param4option = $report->param4type;
                        $param5option = $report->param5type;
                        $param1name = $report->param1name;
                        $param2name = $report->param2name;
                        $param3name = $report->param3name;
                        $param4name = $report->param4name;
                        $param5name = $report->param5name;
                        $param1default = $report->param1default;
                        $param2default = $report->param2default;
                        $param3default = $report->param3default;
                        $param4default = $report->param4default;
                        $param5default = $report->param5default;
                        $filename = $report->filename;
                        $description = $report->description;
                    } else {
                        $report_name = '';
                        $report_id = 0;
                        $query = '';
                        $param1 = '';
                        $param2 = '';
                        $param3 = '';
                        $param4 = '';
                        $param5 = '';
                        $param1option = '';
                        $param2option = '';
                        $param3option = '';
                        $param4option = '';
                        $param5option = '';
                        $param1name = '';
                        $param2name = '';
                        $param3name = '';
                        $param4name = '';
                        $param5name = '';
                        $filename = '';
                        $description = '';
                        $QueryForExport = '';
                        $param1default = '';
                        $param2default = '';
                        $param3default = '';
                        $param4default = '';
                        $param5default = '';
                    }
                    ?>


                        <div class="row">
                            <h2>Reports</h2>
                            <div class="col-md-12 text-right mb-20">
                                <button type="button" id="clear" class="btn btn-primary"  style="margin-right:15px">New</button>
                                <button type="button" id="delete" class="btn btn-danger" style="margin-right:15px">Delete</button>

                            </div>
                            <div class="col-md-3">
                                <div class="ibox float-e-margins">
                                    <div class="row">
                                        <div class="col-sm-12 paddingleft">
                                            <div class="setting-section">
                                                <h5>Select Reports</h5>
                                                <div class="documenttype-section">
                                                    <select id="report-list" class="select-documenttype new-type form-control" size="10">
                                                        <?php
                                                        if($reports){
                                                            foreach ($reports as $report){
                                                                ?>
                                                                <option value="<?php echo $report->id?>"><?php echo $report->ReportName?></option>
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
                                    <button type="button" id="load-report" class="btn btn-primary">Edit</button>
                                    <button type="button" id="Run-Report" class="btn btn-primary">Run</button>
                                </div>
                            </div>
                            <div class="col-md-9" id="sql_form" <?php echo (isset($id))? '' : 'style="display: none"' ?>>
                                <div class="col-md-12">
                                    <div class="ibox float-e-margins">
                                        <div class="row">
                                            <div class="col-sm-12 paddingleft">
                                                <div class="select-report-section">
                                                    <form role="form" id="sqlform" class="form-horizontal" action="<?php echo url('/admin/reports/')?>/get_report" method="post">
                                                        <div class="col-md-12">
                                                            <div class="form-group" >
                                                                <label class="col-sm-12 ">Report Name</label>
                                                                <div class="col-sm-12">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                    <input type="text" class="form-control" id="report_name" name="report_name" value="<?php echo $report_name;?>">
                                                                    <input type="hidden" id="report_id" value="<?php echo $report_id?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group" >
                                                                <label class="col-sm-2 ">File Name</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control" value="<?php echo $filename?>" id="filename" name="filename" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 ">Description</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control" value="<?php echo $description?>" id="description"  name="description" value="">

                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-lg-12 ">SQL Query for Excel Export.</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" name="QueryForExport" id="QueryForExport" style="height:150px !important;"><?php echo $QueryForExport;?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-12 ">SQL Query for Display</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" name="report_query" id="query" style="height:150px !important;"><?php echo $query;?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <label class="col-lg-1">Param 1</label>
                                                                        <div class="col-lg-2">
                                                                            <input class="form-control" type="text" name="param1name" value="<?php echo $param1name?>" id="param1name">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <select name="param1option" class="form-control" id="param1option">
                                                                                <option value="1" <?php echo ($param1option == 1)? 'selected=selected' : ''; ?>>Text</option>
                                                                                <option value="2" <?php echo ($param1option == 2)? 'selected=selected' : ''; ?>>ComboBox</option>
                                                                                <option value="3" <?php echo ($param1option == 3)? 'selected=selected' : ''; ?>>MultiSelect</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" name="param1" value="<?php echo $param1; ?>" id="param1">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <input class="form-control" type="text" name="param1default"  id="param1default" value="<?php echo $param1default; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <label class="col-lg-1">Param 2</label>
                                                                        <div class="col-lg-2">
                                                                            <input class="form-control" type="text" name="param2name" value="<?php echo $param2name?>" id="param2name">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <select name="param2option" class="form-control" id="param2option">
                                                                                <option value="1" <?php echo ($param2option == 1)? 'selected=selected' : ''; ?>>Text</option>
                                                                                <option value="2" <?php echo ($param2option == 2)? 'selected=selected' : ''; ?>>ComboBox</option>
                                                                                <option value="3" <?php echo ($param2option == 3)? 'selected=selected' : ''; ?>>MultiSelect</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" name="param2" value="<?php echo $param2; ?>" id="param2">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <input class="form-control" type="text" name="param2default"  id="param2default" value="<?php echo $param2default; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <label class="col-lg-1">Param 3</label>
                                                                        <div class="col-lg-2">
                                                                            <input class="form-control" type="text" name="param3name" value="<?php echo $param3name?>" id="param3name">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <select name="param3option" class="form-control" id="param3option">
                                                                                <option value="1" <?php echo ($param3option == 1)? 'selected=selected' : ''; ?>>Text</option>
                                                                                <option value="2" <?php echo ($param3option == 2)? 'selected=selected' : ''; ?>>ComboBox</option>
                                                                                <option value="3" <?php echo ($param3option == 3)? 'selected=selected' : ''; ?>>MultiSelect</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" name="param3" value="<?php echo $param3; ?>" id="param3">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <input class="form-control" type="text" name="param3default"  id="param3default" value="<?php echo $param3default; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <label class="col-lg-1">Param 4</label>
                                                                        <div class="col-lg-2">
                                                                            <input class="form-control" type="text" name="param4name" value="<?php echo $param4name?>" id="param4name">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <select name="param4option" class="form-control" id="param4option">
                                                                                <option value="1" <?php echo ($param4option == 1)? 'selected=selected' : ''; ?>>Text</option>
                                                                                <option value="2" <?php echo ($param4option == 2)? 'selected=selected' : ''; ?>>ComboBox</option>
                                                                                <option value="3" <?php echo ($param4option == 3)? 'selected=selected' : ''; ?>>MultiSelect</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" name="param4" value="<?php echo $param4; ?>" id="param4">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <input class="form-control" type="text" name="param4default"  id="param4default" value="<?php echo $param4default; ?>">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <label class="col-lg-1">Param 5</label>
                                                                        <div class="col-lg-2">
                                                                            <input class="form-control" type="text" name="param5name" value="<?php echo $param5name?>" id="param5name">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <select name="param5option" class="form-control" id="param5option">
                                                                                <option value="1" <?php echo ($param5option == 1)? 'selected=selected' : ''; ?>>Text</option>
                                                                                <option value="2" <?php echo ($param5option == 2)? 'selected=selected' : ''; ?>>ComboBox</option>
                                                                                <option value="3" <?php echo ($param5option == 3)? 'selected=selected' : ''; ?>>MultiSelect</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <input class="form-control" type="text" name="param5" value="<?php echo $param5; ?>" id="param5">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <input class="form-control" type="text" name="param5default"  id="param5default" value="<?php echo $param5default; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="select-report-btn text-right">
                                                            <button type="submit" id="run-report" class="btn btn-primary">Run</button>
                                                            <input type="button" id="save_report" class="btn btn-primary" value="Save">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        $(document).ready(function(){

            $('#save_report').click(function(){
                var query = $('#query').val();
                var report_name = $('#report_name').val();
                if(query == ''){
                    alert('Query is Required');
                    return;
                }
                if(report_name == ''){
                    alert('Report Name is required');
                    return;
                }
               save_report();
            });

            $('#Run-Report').click(function(){
                var report_id = $('#report-list').val();
                if(!report_id){
                    alert('Select Report');
                    return false;
                }
                window.location.href = "<?php echo url('/admin/reports/')?>/run_report/"+report_id;
            });
        });


        function save_report(){
            var query = $('#query').val();
            var QueryForExport = $('#QueryForExport').val();
            var report_name = $('#report_name').val();
            var report_id = $('#report_id').val();
            var param1option = $('#param1option').val();
            var param1 = $('#param1').val();
            var param1name = $('#param1name').val();
            var param2option = $('#param2option').val();
            var param2 = $('#param2').val();
            var param2name = $('#param2name').val();
            var param3option = $('#param3option').val();
            var param3 = $('#param3').val();
            var param3name = $('#param3name').val();
            var param4option = $('#param4option').val();
            var param4 = $('#param4').val();
            var param4name = $('#param4name').val();
            var param5option = $('#param5option').val();
            var param5 = $('#param5').val();
            var param5name = $('#param5name').val();
            var param1default = $('#param1default').val();
            var param2default = $('#param2default').val();
            var param3default = $('#param3default').val();
            var param4default = $('#param4default').val();
            var param5default = $('#param5default').val();
            var filename = $('#filename').val();
            var description = $('#description').val();
            
            $.ajax({
                type: 'POST',
                async: false,
                url: "<?php echo url('/admin/reports/'); ?>/save_report/" + report_id,
                data: {
                    "_token": "{{ csrf_token() }}",
                    query: query,
                    report_name: report_name,
                    param1option: param1option,
                    param1: param1,
                    param1name:param1name,
                    param2option: param2option,
                    param2: param2,
                    param2name:param2name,
                    param3option: param3option,
                    param3: param3,
                    param3name:param3name,
                    param4option: param4option,
                    param4: param4,
                    param4name:param4name,
                    param5option: param5option,
                    param5: param5,
                    param5name:param5name,
                    param1default:param1default,
                    param2default:param2default,
                    param3default:param3default,
                    param4default:param4default,
                    param5default:param5default,
                    filename:filename,
                    description:description,
                    QueryForExport:QueryForExport,

                },
                success: function (data) {
                    location.reload();
                }
            });
        }

        $('#delete').click(function(){
            var id = $('#report-list').val();
            if(id == null){
                alert('Select Report');
                return false;
            } 

            if(confirm('Are you sure?')){
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: "<?php echo url('/admin/reports/'); ?>/delete_report/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function () {
                        window.location.href = "<?php echo url('/admin/reports/')?>";
                    }
                });
            }
            
        });

        $('#clear').click(function(){
            //window.location.href = "<?php //echo url('/admin/reports/')?>//reports";
            $('#sql_form').show();
            $('#sqlform').find('input[type=text], textarea , select',).val('');
            $('#report_id').val(0);
        });

    $('#load-report').click(function(){
        var report_id = $('#report-list').val();
        if(report_id == null){
            alert('Select Report');
            return;
        }
        window.location.href = "<?php echo url('/admin/reports/')?>/load_report/"+report_id;



    });
    $('#export_excel').click(function(){
        var query = $('#query').val();
        var QueryForExport = $('#QueryForExport').val();
      
        if(query != ''){
            $.ajax({
                type: 'POST',
                async: false,
                url: "<?php echo url('/admin/reports/'); ?>/set_report_session_value/",
                data: {
                    "_token": "{{ csrf_token() }}",
                    report_query: query,
                    QueryForExport: QueryForExport,
                 
                },
                success: function () {
                    window.location.href = "<?php echo url('/admin/reports/')?>reports/generate_report_csv";
                }
            });
        }else{
            alert('Please enter the query.');
        }
    });



    </script>
    @endsection