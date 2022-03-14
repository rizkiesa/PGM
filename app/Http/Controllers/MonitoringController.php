<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use App\Models\MarkedChart;
use App\Models\MarkedStatic;
use App\Models\MarkedL1;
use App\Models\MasterTreasury;
use stdClass;
use App\Models\MasterData;

class MonitoringController extends Controller
{
    private $page_title         = "Payment Gateway Monitoring";
    private $route              = "monitoring.index";
    private $permission         = "monitoring.index"; //1
    private $pageConfigs        = ['pageHeader' => false];

    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:' . $this->permission . '.index|' . $this->permission . '.create|' . $this->permission . '.edit|' . $this->permission . '.delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:' . $this->permission . '.create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:' . $this->permission . '.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:' . $this->permission . '.delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $headerSearch = 'Daily Instruments Summary';

        $data = MasterData::all();

        $page_title         = "Daily Instruments Summary";
        // dd($this->page_title);
        return view('monitoring.index', [
            'pageConfigs'   => $this->pageConfigs,
            'page_title'    => $this->page_title,
            'permission'    => $this->permission,
            'route'         => $this->route,
            'page_title'    => $this->page_title,

            'data'          => $data
        ]);
    }

    public function datatableL0(Request $req)
    {
        // if ($req->ajax()) {
        //     //Query utk datatable (sama dengan chart, tapi tidak pakai get)
        //     $model =  MarkedL1::select('item')->where('tanggal', '>=', $req->start)
        //         ->where('tanggal', '<=', $req->end)
        //         ->where('card', 'LIKE', 'instrument-%')
        //         ->selectRaw('sum(totals) as totals, sum(profit_idr) as profit_idr, sum(base_amount_idr) as base_amount_idr')->groupBy('item');

        //     return DataTables::of($model)
        //         ->make(true);
        // }
    }
    public function datatableL1(Request $req)
    {
        // dd($req->paramL0);
        // if ($req->ajax()) {
        //     $passVar = $req->menu_l0;
        //     if (isset($passVar)) {
        //         $passVar2 = $passVar;
        //     } else {
        //         $passVar2 = NULL;
        //     }

        //     //Query utk datatable (sama dengan chart, tapi tidak pakai get)
        //     $model =  MasterTreasury::select('currency_base', 'currency_quote', 'branch_name', 'instrument_name', 'base_amount', 'base_amount_idr', 'FId', 'profit_idr')
        //         ->where('instrument_name', $passVar2)
        //         ->where('date_stamp', '>=', $req->awal)
        //         ->where('date_stamp', '<=', $req->akhir)
        //         ->whereBetween('FFlag', [0, 1]);

        //     return DataTables::of($model)
        //         ->addIndexColumn()
        //         //menggabungkan currency Pair
        //         ->addColumn('currency_pair', function ($data) {
        //             $currencyPair = $data->currency_base . '/' . $data->currency_quote;
        //             return ($currencyPair);
        //         })
        //         ->rawColumns(['currency_pair'])
        //         ->addColumn('action', function ($data) {
        //             $button = '<!-- Button trigger modal -->
        //     <button type="button" class="btn btn-primary btn-sm" onClick="reply_click(this.id)" data-toggle="modal" id="' . $data->FId . '">
        //       Details
        //     </button>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
    }
    public function datatableL2(Request $req)
    {
        // if ($req->ajax()) {
        //     //Query utk datatable (sama dengan chart, tapi tidak pakai get)
        //     $model =  MasterTreasury::select('*')->where('FId', $req->id)
        //         ->first()->toArray();

        //     return response()->json($model);
        // }
    }
}
