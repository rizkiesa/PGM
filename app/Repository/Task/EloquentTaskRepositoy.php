<?php

namespace App\Repository\Task;
//EloquentTaskRepositoy EloquentTaskRepositoy.php. 
use App\Repository\Task\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EloquentTaskRepository implements TaskRepository
{

    // DISINI TEMPAT BUAT QUERY UNTUK API 

    public function updateTask()
    {
        dd('farhan');
        //    $task = Task::whereId($id)->first();
        //     if ($task != null) {
        //         $task->update([
        //             'name' => $request->name,
        //             'description' => $request->description,
        //         ]);
        //         return $task;
        //     }
        //     return null;
    }

    // SUMMARY DASHBOARD 
    public function summary_dashboard(Request $req)
    {
        switch ($req['summary']) {
            case 'today':
                $data = DB::connection('sqlsrv_bifast')->select("exec data_staging_bifast.dbo.usp_summary_now")[0];
                break;
            case 'yesterday':
                $data = DB::connection('sqlsrv_bifast')->select("exec data_staging_bifast.dbo.usp_summary_yesterday")[0];
                break;
            case 'month':
                $data = DB::connection('sqlsrv_bifast')->select("exec data_staging_bifast.dbo.usp_summary_month")[0];
                break;

            default:
                break;
        }
        return $data;
    }

    public function summary_weekly(Request $req)
    {
        $data       = DB::connection('sqlsrv_bifast')->select('exec data_staging_bifast.dbo.usp_summary_chart_week');
        $incoming   = [];
        $outgoing   = [];
        $record     = [];
        foreach ($data as $key => $value) {
            $incoming[$key]['x'] = $value->time;
            $incoming[$key]['y'] = $value->totalTransactionIncoming;

            $outgoing[$key]['x'] = $value->time;
            $outgoing[$key]['y'] = $value->totalTransactionOutgoing;
        }
        $record[0]['name'] = 'Incoming';
        $record[0]['data'] = $incoming;
        $record[1]['name'] = 'Outgoing';
        $record[1]['data'] = $outgoing;
        return $record;
    }

    public function summary_monthly(Request $req)
    {
        $data       = DB::connection('sqlsrv_bifast')->select('exec data_staging_bifast.dbo.usp_summary_chart_month');
        $incoming   = [];
        $outgoing   = [];
        $record     = [];
        foreach ($data as $key => $value) {
            $incoming[$key]['x'] = $value->time;
            $incoming[$key]['y'] = $value->totalTransactionIncoming;

            $outgoing[$key]['x'] = $value->time;
            $outgoing[$key]['y'] = $value->totalTransactionOutgoing;
        }
        $record[0]['name'] = 'Incoming';
        $record[0]['data'] = $incoming;
        $record[1]['name'] = 'Outgoing';
        $record[1]['data'] = $outgoing;
        return $record;
    }

    public function summary_yearly(Request $req)
    {
        $data       = DB::connection('sqlsrv_bifast')->select('exec data_staging_bifast.dbo.usp_summary_chart_year');
        $incoming   = [];
        $outgoing   = [];
        $record     = [];
        foreach ($data as $key => $value) {
            $incoming[$key]['x'] = $value->time;
            $incoming[$key]['y'] = $value->totalTransactionIncoming;

            $outgoing[$key]['x'] = $value->time;
            $outgoing[$key]['y'] = $value->totalTransactionOutgoing;
        }
        $record[0]['name'] = 'Incoming';
        $record[0]['data'] = $incoming;
        $record[1]['name'] = 'Outgoing';
        $record[1]['data'] = $outgoing;
        return $record;
    }

    public function summary_topThree_incoming(Request $req)
    {
        switch ($req['param']) {
            case 'weekly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_weekly_incoming_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionIncoming;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_weekly_incoming_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionIncoming
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            case 'monthly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_monthly_incoming_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionIncoming;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_monthly_incoming_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionIncoming
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            case 'yearly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_yearly_incoming_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionIncoming;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_yearly_incoming_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionIncoming
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            default:
                # code...
                break;
        }
        if ($req['param'] == 'weekly') {
            # code...
        }

        // dd($data);
        return json_encode($data);
    }

    public function summary_topThree_outgoing(Request $req)
    {
        switch ($req['param']) {
            case 'weekly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_weekly_outgoing_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionOutgoing;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_weekly_outgoing_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionOutgoing
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            case 'monthly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_monthly_outgoing_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionOutgoing;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_monthly_outgoing_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionOutgoing
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            case 'yearly':
                $data   = DB::connection('sqlsrv_bifast')->Select('EXEC [dbo].[usp_summary_top_yearly_outgoing_trx]');
                $record = [];
                $no     = 0;
                foreach ($data as $key => $value) {
                    $record[$no]['name'] = $value->receiver_bank_code . ' T:' . $value->totalTransactionOutgoing;

                    // get detail 
                    $provider = DB::connection('sqlsrv_bifast')->Select("EXEC [dbo].[usp_summary_top_yearly_outgoing_trx_detail]  @provider= '$value->receiver_bank_code'");
                    foreach ($provider as $k => $v) {
                        $record[$no]['data'][] = [
                            "x" => $v->time,
                            "y" => $v->totalTransactionOutgoing
                        ];
                    }
                    $no++;
                }
                $data = $record;
                break;
            default:
                # code...
                break;
        }
        if ($req['param'] == 'weekly') {
            # code...
        }

        // dd($data);
        return json_encode($data);
    }

    // DAILY VIEW BY TIME 
    public function time_transaction(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_time]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        if (@$req['chart'] == 'transaction') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_trx
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_trx
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        } elseif (@$req['chart'] == 'amount') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_amt
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_amt
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        }

        return DataTables::of($data)
            ->addColumn('inc_trx', function ($data) {
                return number_format($data->inc_trx);
            })
            ->addColumn('inc_amt', function ($data) {
                return number_format($data->inc_amt, 2);
            })
            ->addColumn('out_trx', function ($data) {
                return number_format($data->out_trx);
            })
            ->addColumn('out_amt', function ($data) {
                return number_format($data->out_amt, 2);
            })
            ->with('total', function () use ($data) {
                $total = 0;
                foreach ($data as $key => $value) {
                    $total += $value->inc_trx;
                    $total += $value->out_trx;
                }
                return $total;
            })
            ->make(true);
    }

    // DAILY VIEW BY TIME 
    public function time_transaction_source(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        $time       = substr($req['time'], 0, 2);
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }
        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_time_source]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "', @time = $time");
        if (@$req['chart'] == 'transaction') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_trx
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_trx
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        } elseif (@$req['chart'] == 'amount') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_amt
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_amt
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        }

        return DataTables::of($data)
            ->addColumn('source', function ($data) {
                return $data->time;
            })
            ->addColumn('inc_trx', function ($data) {
                return number_format($data->inc_trx);
            })
            ->addColumn('inc_amt', function ($data) {
                return number_format($data->inc_amt, 2);
            })
            ->addColumn('out_trx', function ($data) {
                return number_format($data->out_trx);
            })
            ->addColumn('out_amt', function ($data) {
                return number_format($data->out_amt, 2);
            })
            ->with('total', function () use ($data) {
                $total = 0;
                foreach ($data as $key => $value) {
                    $total += $value->inc_trx;
                    $total += $value->out_trx;
                }
                return $total;
            })
            ->make(true);
    }

    public function time_transaction_source_detail(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endDate    = date('Y-m-d');
        $time       = substr($req['time'], 0, 2);
        $source     = $req['source'];
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endDate    = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_time_source_detail]@startDate = '$startDate',@endDate = '$endDate', @time = $time, @source = '$source'");

        return DataTables::of($data)
            ->make(true);
    }

    // DAILY VIEW BY TIME 
    public function provider_transaction(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        if (@$req['chart'] == 'transaction') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_trx
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_trx
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        } elseif (@$req['chart'] == 'amount') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_amt
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_amt
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        }

        return DataTables::of($data)
            ->addColumn('provider', function ($data) {
                return $data->time;
            })
            ->addColumn('inc_trx', function ($data) {
                return number_format($data->inc_trx);
            })
            ->addColumn('inc_amt', function ($data) {
                return number_format($data->inc_amt, 2);
            })
            ->addColumn('out_trx', function ($data) {
                return number_format($data->out_trx);
            })
            ->addColumn('out_amt', function ($data) {
                return number_format($data->out_amt, 2);
            })
            ->with('total', function () use ($data) {
                $total = 0;
                foreach ($data as $key => $value) {
                    $total += $value->inc_trx;
                    $total += $value->out_trx;
                }
                return $total;
            })
            ->make(true);
    }

    // DAILY VIEW BY Provider 
    public function provider_transaction_source(Request $req)
    {
        $provider   = 0;
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        $provider   = trim($req['provider']);
        if (
            @$req['start_date'] && @$req['end_date']
        ) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider_source]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "', @provider = $provider");
        if (@$req['chart'] == 'transaction') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_trx
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_trx
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        } elseif (@$req['chart'] == 'amount') {
            $incoming   = [];
            $outgoing   = [];
            foreach ($data as $key => $value) {
                $incoming[]     =  [
                    'x' => $value->time,
                    'y' => $value->inc_amt
                ];
                $outgoing[]     =  [
                    'x' => $value->time,
                    'y' => $value->out_amt
                ];
            }
            $record[0]['name'] = 'Incoming';
            $record[0]['data'] = $incoming;
            $record[1]['name'] = 'Outgoing';
            $record[1]['data'] = $outgoing;

            return $record;
        }

        return DataTables::of($data)
            ->addColumn('source', function ($data) {
                return $data->time;
            })
            ->addColumn('inc_trx', function ($data) {
                return number_format(
                    $data->inc_trx,
                    2
                );
            })
            ->addColumn('inc_amt', function ($data) {
                return number_format(
                    $data->inc_amt,
                    2
                );
            })
            ->addColumn('out_trx', function ($data) {
                return number_format(
                    $data->out_trx,
                    2
                );
            })
            ->addColumn('out_amt', function ($data) {
                return number_format(
                    $data->out_amt,
                    2
                );
            })
            ->make(true);
    }

    public function provider_transaction_source_detail(Request $req)
    {
        $provider   = 0;
        $source     = 'MEGA HOST';
        $startDate  = date('Y-m-d');
        $endDate    = date('Y-m-d');
        $provider   = $req['provider'];
        $source     = $req['source'];
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endDate    = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider_source_detail] @startDate = '$startDate',@endDate = '$endDate', @provider = $provider, @source = '$source'");
        return DataTables::of($data)
            ->make(true);
    }

    public function advance_search(Request $req)
    {
        $query = "EXEC [dbo].[usp_search] ";
        $query .= isset($req['start_date']) ? " @startDate = '" . $req['start_date'] . "'," : " @startDate = '" . date('Y-m-d') . "',";
        $query .= isset($req['end_date']) ? " @endDate = '" . $req['end_date'] . "'," : " @endDate = '" . date('Y-m-d') . "',";
        $query .= @$req['reffNo'] != '' ? " @reffNo = '" . $req['reffNo'] . "'," : '';
        $query .= @$req['accNo'] != '' ? " @accNo = '" . $req['accNo'] . "'," : '';
        $query .= @$req['sender'] != 'null' ? " @sender = '" . $req['sender'] . "'," : '';
        $query .= @$req['receiver'] != 'null' ? " @receiver = '" . $req['receiver'] . "'," : '';
        $query .= @$req['status'] != 'null' ? " @status = '" . $req['status'] . "'," : '';
        // dd($query);

        $model = DB::connection('sqlsrv_bifast')->select(rtrim($query, ", ")); //Collect(Session('data_bifast_all')); 
        // dd($model);
        return DataTables::of($model)->toJson();
    }

    public function search_detail(Request $req)
    {
        // dd($req->all());
        $query = "EXEC [dbo].[usp_search_detail] ";
        $query .= @$req['source'] != '' ? " @source = '" . $req['source'] . "'," : '';
        $query .= @$req['business_id'] != '' ? " @reffNo = '" . $req['business_id'] . "'," : '';
        $model = DB::connection('sqlsrv_bifast')->select(rtrim($query, ", ")); //Collect(Session('data_bifast_all')); 

        return $model[0];
    }

    // DAILY VIEW BY TIME 
    public function provider_transaction_incoming(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        foreach ($data as $array_key => $array_item) {
            if (($data[$array_key]->inc_trx * 1) === 0) {
                unset($data[$array_key]);
            }
        }

        return DataTables::of($data)
            ->addColumn('provider', function ($data) {
                return $data->time;
            })
            ->addColumn('inc_trx', function ($data) {
                return number_format($data->inc_trx);
            })
            ->addColumn('inc_amt', function ($data) {
                return number_format($data->inc_amt, 2);
            })
            ->addColumn('out_trx', function ($data) {
                return number_format($data->out_trx);
            })
            ->addColumn('out_amt', function ($data) {
                return number_format($data->out_amt, 2);
            })
            ->with('total', function () use ($data) {
                $total = 0;
                foreach ($data as $key => $value) {
                    $total += $value->inc_trx;
                }
                return $total;
            })
            ->make(true);
    }

    public function provider_transaction_incoming_chart(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        if (@$req['chart'] == 'transaction') {
            $incoming   = [];
            foreach ($data as $key => $value) {
                if (($value->inc_trx * 1) != 0) {
                    $incoming[]     =  [
                        'name' => $value->time,
                        'y' =>  $value->inc_trx * 1
                    ];
                }
            }
            $record[0]['name'] = 'Trx';
            $record[0]['data'] = $incoming;

            return $record;
        }
    }

    // DAILY VIEW BY TIME 
    public function provider_transaction_outgoing(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        foreach ($data as $array_key => $array_item) {
            if (($data[$array_key]->out_trx * 1) === 0
            ) {
                unset($data[$array_key]);
            }
        }

        return DataTables::of($data)
            ->addColumn('provider', function ($data) {
                return $data->time;
            })
            ->addColumn('out_trx', function ($data) {
                return number_format($data->out_trx);
            })
            ->addColumn('out_amt', function ($data) {
                return number_format(
                    $data->out_amt,
                    2
                );
            })
            ->with('total', function () use ($data) {
                $total = 0;
                foreach ($data as $key => $value) {
                    $total += $value->out_trx;
                }
                return $total;
            })
            ->make(true);
    }

    public function provider_transaction_outgoing_chart(Request $req)
    {
        $startDate  = date('Y-m-d');
        $endtDate   = date('Y-m-d');
        if (@$req['start_date'] && @$req['end_date']) {
            $startDate  = $req['start_date'];
            $endtDate   = $req['end_date'];
        }

        $data = DB::connection('sqlsrv_bifast')->select("EXEC [dbo].[usp_summary_by_provider]@startDate = '" . $startDate . "',@endDate = '" . $endtDate . "'");
        if (@$req['chart'] == 'transaction') {
            $outgoing   = [];
            foreach ($data as $key => $value) {
                if (($value->out_trx * 1) != 0) {
                    $outgoing[]     =  [
                        'name' => $value->time,
                        'y' =>  $value->out_trx * 1
                    ];
                }
            }
            $record[0]['name'] = 'Trx';
            $record[0]['data'] = $outgoing;

            return $record;
        }
    }
}
