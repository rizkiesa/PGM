@extends('layouts/contentLayoutMaster')

@section('title', $page_title)

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection
@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
{{--
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}"> --}}
<style>
    tr {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
@php
$headerSearch = 'Payment Gateway Monitoring';
$dailyChannel = 'daily-instruments-channel';
//$start_date = request()->get('startDate') == null ? $startDate : request()->get('startDate');
//$end_date = request()->get('endDate') == null ? $endDate : request()->get('endDate');
@endphp
{{-- channel search --}}
{{-- end of channel search --}}

{{-- financial-L0 table and chart --}}
<section id="daily-financial-L0_table_chart" style="display: flex;">
    <div class="card w-100">
        <div class="card-header border-bottom">
            <div class="head-title ">
                <h4 class="mb-0">{{ $headerSearch }} Table</h4>
            </div>
        </div>
        {{-- HTML Datatable --}}
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="pt-2 table-responsive">
                        <table class="table table-bordered datatables-ajax-{{ $dailyChannel }}-L0">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" style="vertical-align: middle">TR ID</th>
                                    <th colspan="2">IPG</th>
                                    <th colspan="2">Data Surrounding</th>
                                    <th colspan="2">Host</th>
                                    <th rowspan="2"style="vertical-align: middle">Settlement Status</th>

                                </tr>
                                <tr class="text-center">
                                    <th>TR</th>
                                    <th>SR</th>
                                    <th>TR</th>
                                    <th>SR</th>
                                    <th>TR</th>
                                    <th>SR</th>
                                </tr>
                            </thead>
                            
                            <tbody class="text-center">
                            @foreach ($data as $item)
                            <tr>
                                <td data-toggle="modal" data-target="#modal_tr_id{{ $item->tr_id }}">{{$item->tr_id}}</td>
                                <td data-toggle="modal" data-target="#modal_ipg{{ $item->tr_id }}">{{$item->ipg_tr}}</td>
                                <td data-toggle="modal" data-target="#modal_ipg{{ $item->tr_id }}">{{$item->ipg_sr}}</td>
                                <td data-toggle="modal" data-target="#modal_ds{{ $item->tr_id }}">{{$item->ds_tr}}</td>
                                <td data-toggle="modal" data-target="#modal_ds{{ $item->tr_id }}">{{$item->ds_sr}}</td>
                                <td data-toggle="modal" data-target="#modal_hs{{ $item->tr_id }}">{{$item->hs_tr}}</td>
                                <td data-toggle="modal" data-target="#modal_hs{{ $item->tr_id }}">{{$item->hs_sr}}</td>
                                <td data-toggle="modal" data-target="#modal_status{{ $item->tr_id }}">{{$item->status}}</td>
                            </tr>

                            @endforeach
                            </tbody>
                        </table>


        @foreach ($data as $modal) 
        
        <!-- Modal ketika kolom TR ID diclick -->
        <div class="modal fade" id="modal_tr_id{{ $modal->tr_id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Log Details [TR ID]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="pt-2 table-responsive" style="tr:nth-child(even){background-color: #f8f8f8;}">                        
                                <table class="table details-ajax-{{ $dailyChannel }}-L2">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>TR ID</td>
                                            <td>:</td>
                                            <td>{{$modal->tr_id}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Log</td>
                                            <td>:</td>
                                            <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>IPG TR</td>
                                            <td>:</td>
                                            <td>{{$modal->ipg_tr}}</td>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td>IPG SR</td>
                                            <td>:</td>
                                            <td>{{$modal->ipg_sr}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ketika kolom IPG diclick -->
        <div class="modal fade" id="modal_ipg{{ $modal->tr_id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Log Details [IPG]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="pt-2 table-responsive" style="tr:nth-child(even){background-color: #f8f8f8;}">                        
                                <table class="table details-ajax-{{ $dailyChannel }}-L2">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>TR ID</td>
                                            <td>:</td>
                                            <td>{{$modal->tr_id}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>IPG TR</td>
                                            <td>:</td>
                                            <td>{{$modal->ipg_tr}}</td>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td>IPG SR</td>
                                            <td>:</td>
                                            <td>{{$modal->ipg_sr}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ketika kolom DATA SURROUNDING diclick -->
        <div class="modal fade" id="modal_ds{{ $modal->tr_id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Log Details [DATA SURROUNDING]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="pt-2 table-responsive" style="tr:nth-child(even){background-color: #f8f8f8;}">                        
                                <table class="table details-ajax-{{ $dailyChannel }}-L2">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>TR ID</td>
                                            <td>:</td>
                                            <td>{{$modal->tr_id}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>DS TR</td>
                                            <td>:</td>
                                            <td>{{$modal->ds_tr}}</td>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td>DS SR</td>
                                            <td>:</td>
                                            <td>{{$modal->ds_sr}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ketika kolom SETTLEMENT STATUS diclick -->
        <div class="modal fade" id="modal_status{{ $modal->tr_id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Log Details [Settlement Status]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="pt-2 table-responsive" style="tr:nth-child(even){background-color: #f8f8f8;}">                        
                                <table class="table details-ajax-{{ $dailyChannel }}-L2">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>TR ID</td>
                                            <td>:</td>
                                            <td>{{$modal->tr_id}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Settlement Status</td>
                                            <td>:</td>
                                            <td>{{$modal->status}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_hs{{ $modal->tr_id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Log Details [HS]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="pt-2 table-responsive" style="tr:nth-child(even){background-color: #f8f8f8;}">                        
                                <table class="table details-ajax-{{ $dailyChannel }}-L2">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>TR ID</td>
                                            <td>:</td>
                                            <td>{{$modal->tr_id}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>HS TR</td>
                                            <td>:</td>
                                            <td>{{$modal->hs_tr}}</td>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td>HS SR</td>
                                            <td>:</td>
                                            <td>{{$modal->hs_sr}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <script>
            $('#exampleModal').on('show.bs.modal', event => {
                var button = $(event.relatedTarget);
                var modal = $(this);
                // Use above variables to manipulate the DOM
                
            });
            
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-5 col-12">
                    <div class="pt-2" id="L0-chart-{{ $dailyChannel }}"></div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- end of financial-L1 table and chart --}}

{{-- <section id="daily-financial-L1_table_chart" style="display: none;">
    <div class="card w-100">
        <div class="card-header border-bottom">
            <div class="head-title">
        <h4 class="mb-0" id="header-table-L1"></h4>
      </div>
      <div class="float-right dt-action-buttons">
        <div class="dt-buttons">
          <a href="javascript:void(0);" onclick="showOnlyL0()" class="dt-button btn btn-primary">
            <i data-feather="chevrons-left"></i>Back
          </a>
        </div>
      </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-7 col-12">
                    <div class="pt-2 table-responsive">
                        <table class="table table-bordered datatables-ajax-{{ $dailyChannel }}-L1">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>Ticket ID</th>
                                    <th>Currency Pair</th>
                                    <th>Instrument</th>
                                    <th>Branch</th>
                                    <th>Base Amount Total</th>
                                    <th>Amount Total (IDR)</th>
                                    <th>Profit (IDR)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section> --}}

{{-- <section id="daily-financial-L2_table_chart" style="display: none;">
    <div class="card w-100">
        <div class="card-header border-bottom">
            <div class="head-title">
        <h4 class="mb-0" id="header-table-L2"></h4>
      </div>
      <div class="float-right dt-action-buttons">
        <div class="dt-buttons">
          <a href="javascript:void(0);" onclick="showOnlyL1()" class="dt-button btn btn-primary">
            <i data-feather="chevrons-left"></i>Back
          </a>
        </div>
      </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-7 col-12">
                    <div class="pt-2 table-responsive">
                        
                    <style>
                        tr:nth-child(even) {
                            background-color: #f8f8f8;
                            }
                        </style>

                        <table class="table details-ajax-{{ $dailyChannel }}-L2">
                            <tbody>
                                <tr class="text-center">
                                
                                    <td>ID</td>
                                    <td>:</td>
                                    <td id="FId"></td>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td id="date_stamp"></td>
                                </tr>
                                <tr class="text-center">
                                    <td>Instrument</td>
                                    <td>:</td>
                                    <td id="instrument_name"></td>
                                    <td>Branch</td>
                                    <td>:</td>
                                    <td id="branch_name"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Base Currency</td>
                                    <td>:</td>
                                    <td id="currency_base"></td>
                                    <td>Quote Currency</td>
                                    <td>:</td>
                                    <td id="currency_quote"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Base Amount</td>
                                    <td>:</td>
                                    <td id="base_amount"></td>
                                    <td>Quote Amount</td>
                                    <td>:</td>
                                    <td id="FAmount"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Bid Ask</td>
                                    <td>:</td>
                                    <td id="FBidAsk"></td>
                                    <td>Base Quote</td>
                                    <td>:</td>
                                    <td id="FBaseQuote"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Branch Rate</td>
                                    <td>:</td>
                                    <td id="FBranchRate"></td>
                                    <td>FIoRate</td>
                                    <td>:</td>
                                    <td id="FIORate"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Customer Rate</td>
                                    <td>:</td>
                                    <td id="FCustomerRate"></td>
                                    <td>Client ID</td>
                                    <td>:</td>
                                    <td id="FClient"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>FTriggerFixScale</td>
                                    <td>:</td>
                                    <td id="FTriggerFixScale"></td>
                                    <td>Profit Scale</td>
                                    <td>:</td>
                                    <td id="FProfitFixScale"></td>
                                </tr>
                                <tr class="text-center">
                                
                                    <td>Total Amount (IDR)</td>
                                    <td>:</td>
                                    <td id="base_amount_idr"></td>
                                    <td>Profit (IDR)</td>
                                    <td>:</td>
                                    <td id="profit_idr"></td>
                                </tr>
                            </tbody>
                            

                        </table>

                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</section> --}}
@endsection

@push('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endpush
@push('page-script')
{{-- Page js files --}}
{{-- <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script> --}}
<script>
    // DATATABLES
   

    var dt_ajax_table_L0 = $('.datatables-ajax-{{ $dailyChannel }}-L0'),
    dt_ajax_table_L1 = $('.datatables-ajax-{{ $dailyChannel }}-L1'),
    dataDetails = $('.details-ajax-{{ $dailyChannel }}-L2');
    //Setup Datatable

        //# # # # # # # # # # # # # # # # # # # # # #
        //                 Da # #tatable L0              #
        //# # # # # # # # # # # # # # # # # # # # # #

        //# # # # # # # # # # # # # # # # # # # #
        //                 Datatable L1              #
        //# # # # # # # # # # # # # # # # # # # # # #           
        
            

    

</script>


@endpush