<?php

namespace App\Exports;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TotalCellLogExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data=[Carbon::now()->subDay()->format("Y-m-d H:i:s"), Carbon::now()->format("Y-m-d H:i:s")];
        switch ($this->month){
            case "Today":
                $data=[Carbon::now()->subDay()->format("Y-m-d H:i:s"), Carbon::now()->format("Y-m-d H:i:s")];
                break;
            case "Week":
                $data=[Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()->format("Y-m-d H:i:s")];
                break;
            case "Month":
                $data=[Carbon::now()->subMonth()->format("Y-m-d H:i:s"), Carbon::now()->format("Y-m-d H:i:s")];
                break;
        }
        $query = DB::raw("(CASE WHEN cell_status=1 THEN 'CELL DOWN' WHEN cell_status=0 THEN 'CELL UP' ELSE 'NONE' END) as cell_status");
        $type = DB::table('cell_down_log')->select('code',
            'vender',
            'remark',
            'type',
            'time_down_cell',
            'date_down_cell',
            'reported_to',
            'reported_by',
            'site_name',
            'l_1escalation',
            'l_2escalation',
            'l_3escalation',
            'down_cell_name',
            'region',
            $query,
            'fault_type',
            'date_of_clear',
            'fault_clear_action',
            'inoc_tl_name',
            'remark_clear',
            'cell_up_reported_by',
            'created_at',

        )->where('status', 0)->whereBetween('date_down_cell',$data )
            ->get();
        return $type;
    }

    public function headings(): array
    {
        return [
            'Code',
            'Vendor',
            'Remark',
            'Type',
            'Time Down Cell',
            'Date Down Cell',
            'Reported To',
            'Reported By',
            'Site Name',
            'L1 Escalation',
            'L2 Escalation',
            'L3 Escalation',
            'Down Cell Name',
            'Region',
            'Cell Status',
            'Fault Type',
            'Date of Clear',
            'Fault Clear Action',
            'INOC TL Name',
            'Remark Clear',
            'Cell Up Reported By',
            'Created At'
        ];
    }
}
