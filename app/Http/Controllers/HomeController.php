<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user != null) {
            $cellup = DB::select("select count(id) as amount from  cell_down_log where status=0 and cell_status=0 and date(date_down_cell)=date(now())  limit 1 ");
            $celldown = DB::select("select count(id) as amount from  cell_down_log where status=0  and date(date_down_cell)=date(now()) and cell_status=1 limit 1 ");
            $totalactivecells = DB::select("select count(id) as amount from  cell_down_log where status=0 and date(date_down_cell)=date(now()) limit 1 ");
            $cellupdata = $cellup[0]->amount;
            $celldowndata = $celldown[0]->amount;
            $totalactivecellsdata = $totalactivecells[0]->amount;
            return view('dashboard', ['up' => $cellupdata, 'down' => $celldowndata, 'total' => $totalactivecellsdata]);
        } else {
            return redirect("login");
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
