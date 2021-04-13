<?php

namespace App\Http\Controllers;

use App\Models\ReportQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function get_report(Request $request)
    {

        $post = $request->all();

        session(['filename' => $post['filename']]);
        session(['description' => $post['description']]);

        $query = $post['report_query'];
        $query_for_export = $post['QueryForExport'];

        if (strpos($query, '{param1}') !== false) {
            return $this->load_report_page_with_parameters($post);
        }

        if ($query != '') {

            return $this->generate_report_table($query, false, $query_for_export);

        }
    }

    public function load_report_page_with_parameters($post)
    {

        $query = $post['report_query'];
        $data_view['query'] = $query;
        $data_view['QueryForExport'] = $post['QueryForExport'];

        for ($i = 1; $i <= 5; $i++) {
            if (strpos($query, "{param" . $i . "}") !== false) {
                $data_view["field" . $i . "type"] = $type = $post["param" . $i . "option"];
                $data_view["field" . $i . "name"] = $post["param" . $i . "name"];
                $data_view["field" . $i . "data"] = '';
                $data_view["field" . $i . "default"] = (!empty($post["param" . $i . "default"])) ? $this->get_query($post["param" . $i . "default"]) : '';
                if ($type == 2 || $type == 3) {
                    $data_view["field" . $i . "data"] = $this->get_query($post["param" . $i . ""]);

                }

            }

        }

        return view('admin.reports.select-report-parameters', compact('data_view'))->render();

    }

    public function run_report_with_parameters(Request $request)
    {

        $post = $request->all();
        $query = $post['query'];
        $query_for_export = $post['QueryForExport'];

        $query = $this->parse_query($query, $post);
        $query_for_export = $this->parse_query($query_for_export, $post);

        if ($query != '') {
            return $this->generate_report_table($query, false, $query_for_export);
        }
    }

    public function parse_query($query, $post)
    {

        for ($i = 1; $i <= 5; $i++) {
            if (strpos($query, '{param' . $i . '}') !== false) {

                session(['filename' => str_replace('{param' . $i . '}', $post['param' . $i . ''], session('filename'))]);
                session(['description' => str_replace('{param' . $i . '}', $post['param' . $i . ''], session('description'))]);
            }

            if (isset($post['param' . $i . ''])) {
                $param = $post['param' . $i . ''];
                if (is_array($param)) {
                    $param = '(' . implode(',', $param) . ')';
                } else {
                    $param = "'" . $param . "'";
                }
            }

            if (strpos($query, '{param' . $i . '}') !== false) {
                $query = str_replace('{param' . $i . '}', $param, $query);

                session(['filename' => str_replace('{param' . $i . '}', $param, session('filename'))]);
                session(['description' => str_replace('{param' . $i . '}', $param, session('description'))]);
            }

        }

        return $query;
    }

    public function get_front_report()
    {
        $id = $this->input->post('id');
        $rs = $this->General_model->get_row_arr('ReportQueries', array('ID' => $id[0]));
        $query = $rs->Query;

        if (strpos($query, '{CURRENT_USER_ID}') !== false) {
            $id = $this->session->userdata('ID');
            $query = str_replace("{CURRENT_USER_ID}", $id, $query);
        }

//        $query = $this->General_model->get_row('ReportQueries' , 'ID' , $report_id[0]);
        if ($query != '') {
            $data['table'] = $this->get_query($query);
            $this->session->set_userdata('report_query', $query);

            return view('report/report_generator', compact('table'))->render();

        }
    }
    public function index()
    {

        $report = '';
        $user = Auth::user();

        if ($user->role != 1) {
            $reports = $user->reports;
        } else {
            $reports = ReportQuery::all();
        }

        return view('admin.reports.select-report', compact('reports', 'report'));

    }

    public function save_report(Request $request, $id)
    {
        $post = $request->all();
        $insert_array = array(
            'ReportName' => $post['report_name'],
            'Query' => $post['query'],
            'param1type' => $post['param1option'],
            'param2type' => $post['param2option'],
            'param3type' => $post['param3option'],
            'param4type' => $post['param4option'],
            'param5type' => $post['param5option'],
            'param1data' => $post['param1'],
            'param2data' => $post['param2'],
            'param3data' => $post['param3'],
            'param4data' => $post['param4'],
            'param5data' => $post['param5'],
            'param1name' => $post['param1name'],
            'param2name' => $post['param2name'],
            'param3name' => $post['param3name'],
            'param4name' => $post['param4name'],
            'param5name' => $post['param5name'],
            'param1default' => $post['param1default'],
            'param2default' => $post['param2default'],
            'param3default' => $post['param3default'],
            'param4default' => $post['param4default'],
            'param5default' => $post['param5default'],
            'filename' => $post['filename'],
            'description' => $post['description'],
            'QueryForExport' => $post['QueryForExport'],
        );

        if ($id) {
            $reportQuery = ReportQuery::find($id);
            $reportQuery->fill($insert_array);
            $reportQuery->update();
        } else {
            $reportQuery = new ReportQuery();
            $reportQuery->fill($insert_array);
            $reportQuery->save();
        }
        redirect('reports');
    }

    public function set_report_session_value(Request $request)
    {
        $query = $request->report_query;
        $QueryForExport = $request->QueryForExport;

        ini_set('memory_limit', '512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize', '70240'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '70240'); // Setting to 512M - for pdo_sqlsrv
        if (strpos($query, '{CURRENT_USER_ID}') !== false) {
            $id = Auth::id();
            $query = str_replace("{CURRENT_USER_ID}", $id, $query);
        }
        if ($query != '') {

            session(['report_query' => $query]);
            session(['query_for_export' => $QueryForExport]);

        }
    }

    public function set_front_report_session_value(Request $request)
    {
        $rep_id = $request->id;
        $rs = ReportQuery::find($rep_id);
        $query = $rs->Query;
        $report_query_for_export = $rs->QueryForExport;
        if (strpos($query, '{CURRENT_USER_ID}') !== false) {
            $id = Auth::id();
            $query = str_replace("{CURRENT_USER_ID}", $id, $query);
        }
        if (strpos($report_query_for_export, '{CURRENT_USER_ID}') !== false) {
            $id = Auth::id();
            $report_query_for_export = str_replace("{CURRENT_USER_ID}", $id, $report_query_for_export);
        }
        if ($query != '') {

            session(['query_for_export' => $report_query_for_export]);

        }
    }
    public function generate_report_csv()
    {

        $query = session('query_for_export');
        $result = $this->get_query($query);

        $data = array();
        if (!empty($result)) {
            $flag = true;
            $i = 0;
            foreach ($result as $caption => $row) {
                if ($flag) {
                    $arr = array();
                    foreach ($row as $caption => $col) {
                        array_push($arr, $caption);
                    }
                    $flag = false;
                    array_push($data, $arr);
                }
                $arr1 = array();
                foreach ($row as $caption => $col) {
                    array_push($arr1, $col);
                }
                array_push($data, $arr1);
            }
        }

        $filename = session('filename');
        $description = session('description');
        if ($filename == '') {
            $filename = 'Report';
        }

        if (strpos($filename, ' {DateNow}') !== false) {
            $filename = str_replace('{DateNow}', Date('Y-m-d'), $filename);
        }
        if (strpos($description, ' {DateNow}') !== false) {
            $description = str_replace('{DateNow}', Date('Y-m-d'), $description);
        }

        header('Content-type: text/csv;');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        header('Pragma: no-cache');

        header('Expires: 0');
        $file = fopen('php://output', 'w');

        fputcsv($file, array($description));
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        exit();
    }

    public function delete_report(Request $request, $id)
    {

        if ($id) {
            ReportQuery::destroy($id);
            return true;
        }

    }

    public function load_report($id)
    {

        $reports = ReportQuery::all();
        $report_table = '';
        $report = ReportQuery::find($id);

        return view('admin.reports.select-report', compact('reports', 'report', 'id', 'report_table'));
    }

    public function run_report($id)
    {
        error_reporting(0);

        $report = ReportQuery::find($id);

        session(['filename' => $report->filename]);
        session(['description' => $report->description]);

        $post['report_query'] = $report->Query;
        $post['param1option'] = $report->param1type;
        $post['param1'] = $report->param1data;
        $post['param1name'] = $report->param1name;
        $post['param2option'] = $report->param2type;
        $post['param2'] = $report->param2data;
        $post['param2name'] = $report->param2name;
        $post['param3option'] = $report->param3type;
        $post['param3'] = $report->param3data;
        $post['param3name'] = $report->param3name;
        $post['param4option'] = $report->param4type;
        $post['param4'] = $report->param4data;
        $post['param4name'] = $report->param4name;
        $post['param5option'] = $report->param5type;
        $post['param5'] = $report->param5data;
        $post['param5name'] = $report->param5data;

        $query = $post['report_query'];

        if (strpos($query, '{param1}') !== false) {
            return $this->load_report_page_with_parameters($post);
        }

        if ($query != '') {
            return $this->generate_report_table($query, $report);
        }
    }

    public function get_query($query)
    {

        $result = DB::select(DB::raw($query));

        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function generate_report_table($query, $report = false, $query_for_export = false)
    {

        ini_set('memory_limit', '512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize', '70240'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '70240'); // Setting to 512M - for pdo_sqlsrv
        $table = $this->get_query($query);
        $report_table = '';
        if ($table) {
            $report_table = view('admin.reports.report_generator', compact('table'))->render();

            if ($report) {
                session(['report_query' => $query]);
                session(['query_for_export' => $report->QueryForExport]);

            }

            if ($query_for_export) {
                session(['query_for_export' => $query_for_export]);
            }

        }
        return view('admin.reports.report-table', compact('report_table'))->render();

    }
}
