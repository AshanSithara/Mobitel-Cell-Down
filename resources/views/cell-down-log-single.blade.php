@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    @foreach($data as $cell_data)
                        <h5 class="card-title text-xl-center">Cell Down Log Details Record Number :-
                            0{{$cell_data->id}}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Code : {{$cell_data->code}} </label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Vendor
                                    : {{$cell_data->vender}} </label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Remark : {{$cell_data->remark}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Type : {{$cell_data->type}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Time Down Cell
                                    : {{$cell_data->time_down_cell}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Date Down Cell
                                    : {{$cell_data->date_down_cell}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Reported To
                                    : {{$cell_data->reported_to}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Reported By
                                    : {{$cell_data->fullname}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Site Name
                                    : {{$cell_data->site_name}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Down Cell Name
                                    : {{$cell_data->down_cell_name}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">Region : {{$cell_data->region}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">L1 Escalation
                                    : {{$cell_data->l_1escalation}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">L2 Escalation
                                    : {{$cell_data->l_2escalation}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control" style="color: white">L3 Escalation
                                    : {{$cell_data->l_3escalation}}</label>
                            </div>
                            @if($page_status==1)
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">fault Type L1
                                        : {{$cell_data->fault_type}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">fault Type L2
                                        : {{$cell_data->fault_type2}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">Date of Clear
                                        : {{$cell_data->date_of_clear}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">Fault Clear Action
                                        : {{$cell_data->fault_clear_action}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">Remark Clear
                                        : {{$cell_data->remark_clear}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">Cell Up Reported By
                                        : {{$cell_data->cell_up_reported_by_fullname}}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control" style="color: white">Cell Down Day Duration
                                        : {{$cell_data->daycount}} Days</label>
                                </div>

                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <h4 class="card-header">Region User Comments </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>Region User Name</th>
                                <th>Comment</th>
                                <th>Created Date & Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($region_comments as $comment)
                                <tr>
                                    <td>{{$comment->name}}</td>
                                    <td>{{$comment->comment}}</td>
                                    <td>{{$comment->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dragula.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
