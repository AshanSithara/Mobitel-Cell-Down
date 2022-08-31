<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CellDownLogExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

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
            'created_at',

        )->where('status', 0)
            ->where('cell_status',1)
            ->whereBetween('date_down_cell',[Carbon::now()->subDay()->format("Y-m-d H:i:s"), Carbon::now()->format("Y-m-d H:i:s")])
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
            'Created At'
        ];
    }
}
