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
                    <div class="wrapper wrapper-content animated fadeInRight select-report">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="ibox float-e-margins">
                                        <div class="row">
                                            <div class="col-sm-12 paddingleft">
                                                <div class="select-report-section">
                                                    <form role="form"  class="form-horizontal" action="<?php echo url('/admin/reports/')?>/run_report_with_parameters" method="post">
                                                        @csrf
                                                        <div class="col-md-12" style="display: none">
                                                            <div class="form-group">
                                                                <label class="col-lg-12 ">Edit SQL</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" name="query" id="query" style="height:150px !important;">{{ $data_view['query'] }}</textarea>
                                                                    <input type="hidden" name="QueryForExport" id="QueryForExport" value="{{ $data_view['QueryForExport'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @for($i = 1; $i <= 5; $i++)

                                                        @php
                                                            $fieldType = 'field'. $i .'type';
                                                            $fieldDefault = 'field'. $i .'default';
                                                            $fieldName = 'field'. $i .'name';
                                                            $fieldData = 'field'. $i .'data';
                                                        @endphp

                                                         @if(isset($data_view[$fieldType]))
                                                            @if($data_view[$fieldType] == 1)
                                                            <div class="col-md-12">
                                                                <div class="form-group" >
                                                                    <label class="col-sm-3 ">{{ $data_view[$fieldName] }}</label>
                                                                    <div class="col-sm-9">
                                                                    <input class="form-control" name="param{{$i}}" type="text" value="{{$data_view[$fieldDefault]}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @elseif($data_view[$fieldType] == 2)
                                                                <div class="col-md-12">
                                                                    <div class="form-group" >
                                                                        <label class="col-sm-3 ">{{ $data_view[$fieldName] }}</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control" name="param{{$i}}" id="" value="{{$data_view[$fieldDefault]}}">
                                                                                @if(isset($data_view[$fieldData]))
                                                                                    @foreach ($data_view[$fieldData] as $key => $value)
                                                                                        @foreach ($value as $val)
                                                                                            <option value="{{ $val }}">{{ $val }}</option>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @elseif ($data_view[$fieldType] == 3)
                                                                <div class="col-md-12">
                                                                    <div class="form-group" >
                                                                        <label class="col-sm-3 ">{{ $data_view[$fieldName] }}</label>
                                                                        <div class="col-sm-9">
                                                                            <select style="height: 200px;" class="form-control" name="param{{$i}}[]" id="" value="{{$data_view[$fieldDefault]}}" multiple>
                                                                                @if(isset($data_view[$fieldData]))
                                                                                    @foreach ($data_view[$fieldData] as $key => $value)
                                                                                        @foreach ($value as $val)
                                                                                            <option value="{{ $val }}">{{ $val }}</option>
                                                                                            @endforeach
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @endfor


                                                        <div class="select-report-btn text-right">
                                                            <button type="submit" id="run-report" class="btn btn-primary">Run</button>
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
</div>
@endsection
@section('scrip')
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
                url: "<?php echo url('/admin/reports/'); ?>/set_report_session_value/",
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