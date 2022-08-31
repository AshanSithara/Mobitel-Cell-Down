<?php


namespace App\Http\Controllers;


use App\Exports\CellDownLogExport;
use App\Exports\CellupLogExport;
use App\Exports\TotalCellLogExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CellDownManagementController extends Controller
{

    protected $code = null;

    protected function getcode()
    {
        $data = DB:: select("SELECT m.code  from  cell_down_log m ORDER BY m.id DESC LIMIT 1");
        if ($data == []) {
            $this->code = '1';
        } else {
            $fields = explode('CD', $data[0]->code);
            $this->code = (int)$fields[1] + 1;
        }

        return $this->code;
    }

    public function cellTypeReport()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype == 1 || $user->usertype == 2) {
                return view('report-summary-total-sell-down');
            }else{
                return redirect("login");
            }
        }else{
            return redirect("login");
        }
    }

    public function regionReport()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype == 1 || $user->usertype == 2) {
                return view('region-report');
            }else{
                return redirect("login");
            }
        }else{
            return redirect("login");
        }
    }

    public function addCellDownLog(Request $request)
    {
        $vender = $request->input('vender');
        $remark = $request->input('remark');
        $type = $request->input('type');
        $timedown = $request->input('timedown');
        $datedown = $request->input('datedown');
        $reportedto = $request->input('reportedto');
        $sitename = $request->input('sitename');
        $downcellname = $request->input('downcellname');
        $reported_by = $request->input('reported_by');
        $region = $request->input('region');
        $l1escalation = $request->input('l1escalation');
        $l2escalation = $request->input('l2escalation');
        $l3escalation = $request->input('l3escalation');

        $cellCode = "CD" . $this->getcode();

        $cell_down_log = array(
            'code' => $cellCode,
            'vender' => $vender,
            'remark' => $remark,
            'type' => $type,
            'time_down_cell' => $timedown,
            'date_down_cell' => $datedown,
            'reported_to' => $reportedto,
            'reported_by' => $reported_by,
            'site_name' => $sitename,
            'l_1escalation' => $l1escalation,
            'l_2escalation' => $l2escalation,
            'l_3escalation' => $l3escalation,
            'down_cell_name' => $downcellname,
            'region' => $region,
            'cell_status' => 1, //cell Down
        );
        $query = DB::table('cell_down_log')->insert($cell_down_log);
        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Log Added Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Log Added Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    protected function checkUserType($usertype)
    {
        $regionval = null;
        switch ($usertype) {
            case 3:
                $regionval = "Region - 01";
                break;
            case 4:
                $regionval = "Region - 02";
                break;
            case 5:
                $regionval = "Region - 03";
                break;
            case 6:
                $regionval = "Region - 04";
                break;
            case 7:
                $regionval = "Region - 05";
                break;
            case 8:
                $regionval = "Region - 06";
                break;
            case 9:
                $regionval = "Region - 07";
                break;
        }
        return $regionval;
    }

    public function viewCellDowns()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype == 1 || $user->usertype == 2) {
                $data = DB::select("select * from cell_down_log where status=0 and cell_status=1 ");
                return view('view-cell-downs')->with('data', $data);
            } else {
                $region = $this->checkUserType($user->usertype);
                $data = DB::select("select * from cell_down_log where status=0 and region='{$region}' and cell_status=1 ");
                return view('view-cell-downs')->with('data', $data);
            }
        } else {
            return redirect("login");
        }
    }

    public function viewCellups()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype == 1 || $user->usertype == 2) {
                $data = DB::select("select * from cell_down_log where status=0 and cell_status=0");
                return view('view-cell-ups')->with('data', $data);
            } else {
                $region = $this->checkUserType($user->usertype);
                $data = DB::select("select * from cell_down_log where status=0 and region='{$region}' and cell_status=0 ");
                return view('view-cell-ups')->with('data', $data);
            }

        } else {
            return redirect("login");
        }
    }

    public function deleteCellDownLog($id)
    {
        $data = DB::Update("update cell_down_log set status=1 where id='{$id}' and status=0 ");
        if ($data == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Log Deleted Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Log Deleted Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function deleteCellDownLogMulti(Request $request)
    {
        $ids = $request->input('ids');
        $array = json_decode($ids, true);
        $size = sizeof($array);
        $result = false;

        for ($i = 0; $i < $size; $i++) {
            $id = $array[$i]["id"];
            $data = DB::Update("update cell_down_log set status=1 where id='{$id}' and status=0 ");
            if ($data == 1) {
                $result = true;
            } else {
                $result = false;
            }
        }

        if ($result) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Log Deleted Success",
                "data" => []
            );

        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Log Deleted Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function singleCellLog($parm, $id)
    {
        $data = DB::select("select c.*,u.name as fullname,DATEDIFF(c.date_of_clear, c.date_down_cell) as daycount,(select name from users ud where ud.id=c.cell_up_reported_by) as cell_up_reported_by_fullname  from cell_down_log c,users u where u.id=c.reported_by and c.id='{$id}'");
        $data2 = DB::select("select * from region_comment rc,users u where u.id=rc.user_id and cell_log_id='{$id}'");
        return view('cell-down-log-single', ['page_status' => $parm, 'region_comments' => $data2])->with('data', $data);
    }

    public function updateTocellUpMulti(Request $request)
    {
        $ids = $request->input('ids');
        $fault_type = $request->input('fault_type');
        $fault_type2 = $request->input('fault_type2');
        $remark_for_clear = $request->input('remark_for_clear');
        $date_of_clear = $request->input('date_of_clear');
        $fault_clear_action = $request->input('fault_clear_action');
        $inoc_tl_name = $request->input('inoc_tl_name');
        $cell_up_reported_by = $request->input('cell_up_reported_by');

        $cell_down_log = array(
            'fault_type' => $fault_type,
            'fault_type2' => $fault_type2,
            'date_of_clear' => $date_of_clear,
            'fault_clear_action' => $fault_clear_action,
            'inoc_tl_name' => $inoc_tl_name,
            'remark_clear' => $remark_for_clear,
            'cell_up_reported_by' => $cell_up_reported_by,
            'cell_status' => 0, // Cell Up
        );

        $array = json_decode($ids, true);
        $size = sizeof($array);
        $result = false;

        for ($i = 0; $i < $size; $i++) {
            $id = $array[$i]["id"];
            $query = DB::table('cell_down_log')->where('id', $id)->update($cell_down_log);
            if ($query == 1) {
                $result = true;
            } else {
                $result = false;
            }
        }

        if ($result) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Log Details Updated Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Log Details Updated Failed",
                "data" => []
            );
        }

        return response()->json($array2);

    }

    public function updateTocellUp(Request $request)
    {
        $id = $request->input('id');
        $fault_type = $request->input('fault_type');
        $fault_type2 = $request->input('fault_type2');
        $remark_for_clear = $request->input('remark_for_clear');
        $date_of_clear = $request->input('date_of_clear');
        $fault_clear_action = $request->input('fault_clear_action');
        $inoc_tl_name = $request->input('inoc_tl_name');
        $cell_up_reported_by = $request->input('cell_up_reported_by');

        $cell_down_log = array(
            'fault_type' => $fault_type,
            'fault_type2' => $fault_type2,
            'date_of_clear' => $date_of_clear,
            'fault_clear_action' => $fault_clear_action,
            'inoc_tl_name' => $inoc_tl_name,
            'remark_clear' => $remark_for_clear,
            'cell_up_reported_by' => $cell_up_reported_by,
            'cell_status' => 0, // Cell Up
        );
        $query = DB::table('cell_down_log')->where('id', $id)->update($cell_down_log);

        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Log Details Updated Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Log Details Updated Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function getSingleCellLogDetails($id)
    {
        $data = DB::select("select * from cell_down_log where id='{$id}'");
        return $data;
    }

    public function updateCellDownLog(Request $request)
    {
        $vender = $request->input('vender');
        $remark = $request->input('remark');
        $type = $request->input('type');
        $timedown = $request->input('timedown');
        $datedown = $request->input('datedown');
        $reportedto = $request->input('reportedto');
        $sitename = $request->input('sitename');
        $downcellname = $request->input('downcellname');
        $reported_by = $request->input('reported_by');
        $region = $request->input('region');
        $l1escalation = $request->input('l1escalation');
        $l2escalation = $request->input('l2escalation');
        $l3escalation = $request->input('l3escalation');
        $id = $request->input('id');

        $cell_down_log = array(
            'vender' => $vender,
            'remark' => $remark,
            'type' => $type,
            'time_down_cell' => $timedown,
            'date_down_cell' => $datedown,
            'reported_to' => $reportedto,
            'reported_by' => $reported_by,
            'site_name' => $sitename,
            'l_1escalation' => $l1escalation,
            'l_2escalation' => $l2escalation,
            'l_3escalation' => $l3escalation,
            'down_cell_name' => $downcellname,
            'region' => $region
        );

        $query = DB::table('cell_down_log')->where('id', $id)->update($cell_down_log);
        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "Cell Down Log Updated Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Cell Down Log Updated Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function reportDashboardCart($fromdate, $todate)
    {
        $data = DB::select("select (select count(id) from cell_down_log cl2 where status=0 and vender='Huawei' and cl2.date_down_cell=cl.date_down_cell ) as huawei,(select count(id) from cell_down_log cl2 where status=0 and vender='ZTE' and cl2.date_down_cell=cl.date_down_cell ) as zte,date_down_cell as date_down from cell_down_log cl where status=0 and  date_down_cell between '{$fromdate}' and '{$todate}' group by date_down_cell ");
        return $data;
    }

    public function addCellDownLogView()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype == 1 || $user->usertype == 2) {
                return view('add-cell-down');
            } else {
                return redirect("home");
            }

        } else {
            return redirect("login");
        }
    }

    public function totalCellLogDetailExcel($datetype)
    {
        return Excel::download(new TotalCellLogExport($datetype), 'total_cell_log.xlsx');
    }

    public function cellDownLogDetailExcel()
    {
        return Excel::download(new CellDownLogExport(), 'cell_down_log.xlsx');
    }

    public function cellUpLogDetailExcel()
    {
        return Excel::download(new CellupLogExport(), 'cell_up_log.xlsx');
    }

    public function addRegionComment(Request $request)
    {
        $cell_log_id = $request->input('id');
        $user_id = $request->input('userid');
        $comment = $request->input('comment');

        $region_comment = array(
            'cell_log_id' => $cell_log_id,
            'user_id' => $user_id,
            'comment' => $comment
        );
        $query = DB::table('region_comment')->insert($region_comment);
        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "Comment Added Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "Comment Added Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function reportCellReport($searchdate)
    {
        $data1 = 0;
        $data2 = 0;
        $data3 = 0;
        $data4 = 0;
        $data5 = 0;
        $data6 = 0;
        $query1 = DB::select("select count(id) as data1 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='Hua - 4G'");
        $query2 = DB::select("select count(id) as data2 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='Hua - 2G'");
        $query3 = DB::select("select count(id) as data3 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='Hua - 2G/4G'");
        $query4 = DB::select("select count(id) as data4 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='ZTE - 2G/4G'");
        $query5 = DB::select("select count(id) as data5 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='Hua - 3G'");
        $query6 = DB::select("select count(id) as data6 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and type='ZTE - 3G'");

        if (sizeof($query1) > 0) {
            $data1 = $query1[0]->data1;
        }
        if (sizeof($query2) > 0) {
            $data2 = $query2[0]->data2;
        }
        if (sizeof($query3) > 0) {
            $data3 = $query3[0]->data3;
        }
        if (sizeof($query4) > 0) {
            $data4 = $query4[0]->data4;
        }
        if (sizeof($query5) > 0) {
            $data5 = $query5[0]->data5;
        }
        if (sizeof($query6) > 0) {
            $data6 = $query6[0]->data6;
        }

        $array = [
            [
                "name" => "Hua - 4G",
                "value" => $data1
            ],
            [
                "name" => "Hua - 2G",
                "value" => $data2
            ],
            [
                "name" => "Hua - 2G/4G",
                "value" => $data3
            ],
            [
                "name" => "ZTE - 2G/4G",
                "value" => $data4
            ],
            [
                "name" => "Hua - 3G",
                "value" => $data5
            ],
            [
                "name" => "ZTE - 3G",
                "value" => $data6
            ]

        ];

        return $array;

    }

    public function reportCellReportTable(Request $request)
    {

        $searchdate = $request->input('searchdate');
        $uroles = array();
        $data = DB::select("select c.*,u.name as fullname from cell_down_log c,users u  where u.id=c.reported_by and c.status=0 and c.date_down_cell=date('{$searchdate}') order by c.reported_by,c.type");
        $i = 0;
        foreach ($data as $row) {
            $uroles[$i]['vender'] = $row->vender;
            $uroles[$i]['type'] = $row->type;
            $uroles[$i]['region'] = $row->region;
            $uroles[$i]['fullname'] = $row->fullname;
            $i++;
        }

        return $uroles;
    }

    public function reportRegionReportManagement($searchdate)
    {

        $data1 = 0;
        $data2 = 0;
        $data3 = 0;
        $data4 = 0;
        $data5 = 0;
        $data6 = 0;
        $data7 = 0;
        $query1 = DB::select("select count(id) as data1 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}')  and region='Region - 01'");
        $query2 = DB::select("select count(id) as data2 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 02'");
        $query3 = DB::select("select count(id) as data3 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 03'");
        $query4 = DB::select("select count(id) as data4 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 04'");
        $query5 = DB::select("select count(id) as data5 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 05'");
        $query6 = DB::select("select count(id) as data6 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 06'");
        $query7 = DB::select("select count(id) as data7 from cell_down_log where status=0 and date_down_cell=date('{$searchdate}') and region='Region - 07'");

        if (sizeof($query1) > 0) {
            $data1 = $query1[0]->data1;
        }
        if (sizeof($query2) > 0) {
            $data2 = $query2[0]->data2;
        }
        if (sizeof($query3) > 0) {
            $data3 = $query3[0]->data3;
        }
        if (sizeof($query4) > 0) {
            $data4 = $query4[0]->data4;
        }
        if (sizeof($query5) > 0) {
            $data5 = $query5[0]->data5;
        }
        if (sizeof($query6) > 0) {
            $data6 = $query6[0]->data6;
        }
        if (sizeof($query7) > 0) {
            $data7 = $query7[0]->data7;
        }

        $array = [
            [
                "name" => "Region - 01",
                "value" => $data1
            ],
            [
                "name" => "Region - 02",
                "value" => $data2
            ],
            [
                "name" => "Region - 03",
                "value" => $data3
            ],
            [
                "name" => "Region - 04",
                "value" => $data4
            ],
            [
                "name" => "Region - 05",
                "value" => $data5
            ],
            [
                "name" => "Region - 06",
                "value" => $data6
            ],
            [
                "name" => "Region - 07",
                "value" => $data7
            ]


        ];

        return $array;
    }

}
