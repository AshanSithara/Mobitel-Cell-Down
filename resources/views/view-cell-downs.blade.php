@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">View Cell Downs Details</h4>
        </div>
        @if(Auth::user()->usertype==1 || Auth::user()->usertype==2 )
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" onclick="downloadReport()">
                    <i class="btn-icon-prepend" data-feather="download"></i>
                    Download Report
                </button>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->usertype==1 || Auth::user()->usertype==2 )
                        <button type="button" class="btn btn-success btn-icon-text" onclick="getRowData()">
                            <i class="btn-icon-prepend" data-feather="upload"></i>
                            CELL UP SELECTED
                        </button>
                        <button type="button" class="btn btn-danger btn-icon-text" onclick="deleteSelectedData()">
                            <i class="btn-icon-prepend" data-feather="delete"></i>
                            DELETE SELECTED
                        </button>
                    @endif
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="datatablenew" class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Vendor</th>
                                <th>Type</th>
                                <th>Site Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-xl-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $downs_data)
                                <tr>
                                    <td>{{$downs_data->id}}</td>
                                    <td>{{$downs_data->code}}</td>
                                    <td>{{$downs_data->vender}}</td>
                                    <td>{{$downs_data->type}}</td>
                                    <td>{{$downs_data->site_name}}</td>
                                    <td>{{$downs_data->date_down_cell}}</td>
                                    @if($downs_data->cell_status==0)
                                        <td><span class="badge badge-success">UP</span></td>
                                    @elseif($downs_data->cell_status==1)
                                        <td><span class="badge badge-danger">DOWN</span></td>
                                    @endif
                                    <td class="text-xl-center">
                                        <div class="user-btn-wrapper">
                                            <button type="button" onclick="loadSingleView({{$downs_data->id}})"
                                                    class="btn btn-primary btn-primary">View
                                            </button>
                                            @if(Auth::user()->usertype==3)
                                                <button type="button"
                                                        onclick="addAComment('{{$downs_data->id}}','{{$downs_data->code}}')"
                                                        class="btn btn-warning btn-warning">Add a Comment
                                                </button>
                                            @endif
                                            @if(Auth::user()->usertype==1 || Auth::user()->usertype==2 )
                                                @if($downs_data->cell_status==0)
                                                    <button type="button" class="btn btn-success btn-success" disabled>
                                                        Cell
                                                        UP
                                                    </button>
                                                @elseif($downs_data->cell_status==1)
                                                    <button type="button" onclick="onClickCellUp({{$downs_data->id}})"
                                                            class="btn btn-success btn-success">Cell UP
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-secondary btn-secondary"
                                                        onclick="loadEditModalView({{$downs_data->id}})">Edit
                                                </button>
                                                <button type="button" onclick="onClickDelete({{$downs_data->id}})"
                                                        class="btn btn-danger btn-danger">Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div id="modalcellup" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> Cell UP Details </h5>
                                        <button type="button" class="close" data-dismiss="modal" style="color: white"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="text" id="celllogid" class="d-none">
                                                        <label class="control-label">Fault Type L1</label>
                                                        <select id="fault_typetxt" class="form-control">
                                                            <option value="Power" selected>Power</option>
                                                            <option value="SLT TX">SLT TX</option>
                                                            <option value="Mobi TX">Mobi TX</option>
                                                            <option value="Other TX">Other TX</option>
                                                            <option value="Env Effect">Env Effect</option>
                                                            <option value="Generator">Generator</option>
                                                            <option value="Other">Other</option>
                                                            <option value="BTS/NodeB">BTS/NodeB</option>
                                                            <option value="No Acce">No Acce</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Fault Type L2</label>
                                                        <select id="fault_typel2txt" class="form-control">
                                                            <option value='CEB/LECO PD'>CEB/LECO PD</option>
                                                            <option value='Low Volt'>Low Volt</option>
                                                            <option value='Pwr Tri'>Pwr Tri</option>
                                                            <option value='Pwr Diss'>Pwr Diss</option>
                                                            <option value='BT Weak'>BT Weak</option>
                                                            <option value='BT Stolen'>BT Stolen</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Remark for Clear</label>
                                                        <textarea id="remark_for_cleartxt" class="form-control"
                                                                  placeholder="Enter Remark"></textarea>
                                                    </div>
                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Clear</label>
                                                        <input id="date_of_cleartxt" type="date" class="form-control"
                                                               placeholder="Enter Date of Clear">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Fault Clear Action </label>
                                                        <input id="fault_clear_actiontxt" type="text"
                                                               class="form-control"
                                                               placeholder="Enter Fault Clear Action">
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">INOC TL Name</label>
                                                        <input id="inoc_tl_name" type="text" class="form-control"
                                                               placeholder="Enter INOC TL Name ">
                                                        <input id="idlog" type="text" class="form-control d-none">

                                                    </div>
                                                </div><!-- Col -->
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" onclick="cellUpFunction()" class="btn btn-primary">Save
                                            changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="multimodalcellup" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> Cell UP Details </h5>
                                        <button type="button" class="close" data-dismiss="modal" style="color: white"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="text" id="celllogid" class="d-none">
                                                        <label class="control-label">Fault Type L1</label>
                                                        <select id="fault_typetxt" class="form-control">
                                                            <option value="Power" selected>Power</option>
                                                            <option value="SLT TX">SLT TX</option>
                                                            <option value="Mobi TX">Mobi TX</option>
                                                            <option value="Other TX">Other TX</option>
                                                            <option value="Env Effect">Env Effect</option>
                                                            <option value="Generator">Generator</option>
                                                            <option value="Other">Other</option>
                                                            <option value="BTS/NodeB">BTS/NodeB</option>
                                                            <option value="No Acce">No Acce</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Fault Type L2</label>
                                                        <select id="fault_typel2txt" class="form-control">
                                                            <option value='CEB/LECO PD'>CEB/LECO PD</option>
                                                            <option value='Low Volt'>Low Volt</option>
                                                            <option value='Pwr Tri'>Pwr Tri</option>
                                                            <option value='Pwr Diss'>Pwr Diss</option>
                                                            <option value='BT Weak'>BT Weak</option>
                                                            <option value='BT Stolen'>BT Stolen</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Remark for Clear</label>
                                                        <textarea id="remark_for_cleartxt" class="form-control"
                                                                  placeholder="Enter Remark"></textarea>
                                                    </div>
                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Clear</label>
                                                        <input id="date_of_cleartxt" type="date" class="form-control"
                                                               placeholder="Enter Date of Clear">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Fault Clear Action </label>
                                                        <input id="fault_clear_actiontxt" type="text"
                                                               class="form-control"
                                                               placeholder="Enter Fault Clear Action">
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">INOC TL Name</label>
                                                        <input id="inoc_tl_name" type="text" class="form-control"
                                                               placeholder="Enter INOC TL Name ">
                                                    </div>
                                                </div><!-- Col -->
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" onclick="multiCellUpFunction()" class="btn btn-primary">
                                            Save
                                            changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="editmodalload" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Cell Down Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="color: white"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" id="celllogid" class="d-none">
                                                        <label class="control-label">Vendor</label>
                                                        <select id="vendertxt" class="form-control">
                                                            <option value="Huawei">Huawei</option>
                                                            <option value="ZTE">ZTE</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Remark</label>
                                                        <textarea id="remarktxt" class="form-control"
                                                                  placeholder="Enter Remark"></textarea>
                                                    </div>
                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Type</label>
                                                        <select id="typeselect" class="form-control">
                                                            <option value="Hua - 2G/4G">Hua - 2G/4G</option>
                                                            <option value="ZTE - 2G/4G">ZTE - 2G/4G</option>
                                                            <option value="Hua - 2G">Hua - 2G</option>
                                                            <option value="Hua - 4G">Hua - 4G</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Time of Down Cell</label>
                                                        <input id="timetxt" type="time" class="form-control"
                                                               placeholder="Enter Time of Down Cell">
                                                    </div>
                                                </div><!-- Col -->

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Date</label>
                                                        <input id="datetxt" type="date" class="form-control">

                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Reported To</label>
                                                        <input id="reportedto" type="text" class="form-control"
                                                               placeholder="Enter Reported To">
                                                    </div>
                                                </div><!-- Col -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Site Name</label>
                                                        <input id="sitenametxt" type="text" class="form-control"
                                                               placeholder="Enter Site Name">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">L1 Escalation</label>
                                                        <input id="l1Escalationtxt" type="text" class="form-control"
                                                               placeholder="Enter L1 Escalation">
                                                    </div>
                                                </div><!-- Col -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Down Cell Name</label>
                                                        <input id="downcellnametxt" type="text" class="form-control"
                                                               placeholder="Enter Down Cell Name">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">L2 Escalation</label>
                                                        <input id="l2Escalationtxt" type="text" class="form-control"
                                                               placeholder="Enter L2 Escalation">
                                                    </div>
                                                </div><!-- Col -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Region</label>
                                                        <select id="regiontxt" class="form-control">
                                                            <option value="Region - 01">Region - 01</option>
                                                            <option value="Region - 02">Region - 02</option>
                                                            <option value="Region - 03">Region - 03</option>
                                                            <option value="Region - 04">Region - 04</option>
                                                            <option value="Region - 05">Region - 05</option>
                                                            <option value="Region - 06">Region - 06</option>
                                                            <option value="Region - 07">Region - 07</option>
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">L3 Escalation</label>
                                                        <input id="l3Escalationtxt" type="text" class="form-control"
                                                               placeholder="Enter L3 Escalation">
                                                    </div>
                                                </div><!-- Col -->
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" onclick="onClickSaveChanges()" class="btn btn-primary">
                                            Save changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modalCommentModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Region Comment</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="color: white"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Cell Code</label>
                                                        <input id="cellcode" type="text" class="form-control" disabled>
                                                        <input id="cellcodeid" type="text" class="form-control d-none">

                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Comment</label>
                                                        <textarea id="commenttxt" class="form-control"
                                                                  placeholder="Enter Comment"></textarea>
                                                    </div>
                                                </div><!-- Col -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" onclick="commentSubmit()" class="btn btn-primary">
                                            Save Comment
                                        </button>
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


@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
    <script src="{{asset('assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dragula.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
    <script>

        var table = $('#datatablenew').DataTable({
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            'order': [[1, 'asc']]
        });

        let idarr = [];

        function getRowData() {
            idarr = [];
            let rowdata = table.rows({selected: true}).data();
            if (rowdata.length > 0) {
                $.each(rowdata, function (index, rowId) {
                    let id = rowId[0];
                    let idobj = {
                        'id': id
                    };
                    idarr.push(idobj);
                });
                $('#multimodalcellup').modal({show: true});
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Please Select Min. One Row before Submit!', type: 'error'
                });
            }

        }

        function deleteSelectedData() {
            idarr = [];
            let rowdata = table.rows({selected: true}).data();
            if (rowdata.length > 0) {
                $.each(rowdata, function (index, rowId) {
                    let id = rowId[0];
                    let idobj = {
                        'id': id
                    };
                    idarr.push(idobj);
                });
                let form_data = new FormData();
                form_data.append("_token", "{{ csrf_token() }}");
                let idarraydata = JSON.stringify(idarr);
                form_data.append("ids", idarraydata);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'ml-2',
                    confirmButtonText: 'Yes, delete All!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: action + "api/cell-down/delete/multi",
                            method: 'post',
                            data: form_data,
                            enctype: 'multipart/form-data',
                            processData: false,
                            contentType: false,
                            async: true,
                            success: function (result) {
                                if (result.code == 200) {
                                    swalWithBootstrapButtons.fire(
                                        'Deleted!',
                                        'Log has been deleted.',
                                        'success'
                                    )
                                    setInterval(function () {
                                        window.location = action + 'view-cell-down';
                                    }, 3000);
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'Your imaginary Log is safe :)',
                                        'error'
                                    )
                                }

                            },
                            error: function (error) {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Your imaginary Log is safe :)',
                                    'error'
                                )
                            }
                        });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary Log is safe :)',
                            'error'
                        )
                    }
                })
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Please Select Min. One Row before Submit!', type: 'error'
                });
            }
        }

        function multiCellUpFunction() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            let idarraydata = JSON.stringify(idarr);
            form_data.append("ids", idarraydata);
            form_data.append("fault_type", $('#fault_typetxt').val());
            form_data.append("fault_type2", $('#fault_typel2txt').val());
            form_data.append("remark_for_clear", $('#remark_for_cleartxt').val());
            form_data.append("date_of_clear", $('#date_of_cleartxt').val());
            form_data.append("fault_clear_action", $('#fault_clear_actiontxt').val());
            form_data.append("inoc_tl_name", $('#inoc_tl_name').val());
            form_data.append("cell_up_reported_by", '{{Auth::id()}}');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'ml-2',
                confirmButtonText: 'Yes, Cell Up!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: action + "api/cell-down/up/multi",
                        method: 'post',
                        data: form_data,
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        async: true,
                        success: function (result) {
                            if (result.code == 200) {
                                swalWithBootstrapButtons.fire(
                                    'Success!',
                                    'Log has been Cell Up.',
                                    'success'
                                )
                                setInterval(function () {
                                    window.location = action + 'view-cell-down';
                                }, 3000);
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Cell Log is safe :)',
                                    'error'
                                )
                            }

                        },
                        error: function (error) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Cell Log is safe :)',
                                'error'
                            )
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Cell Log is safe :)',
                        'error'
                    )
                }
            })
        }

        $("#fault_typetxt").change(function () {
            let faultval = $('#fault_typetxt').val();
            switch (faultval) {
                case "Power":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='CEB/LECO PD'>CEB/LECO PD</option>" +
                        "<option value='Low Volt'>Low Volt</option>" +
                        "<option value='Pwr Tri'>Pwr Tri</option>" +
                        "<option value='Pwr Diss'>Pwr Diss</option>" +
                        "<option value='BT Weak'>BT Weak</option>" +
                        "<option value='BT Stolen'>BT Stolen</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "SLT TX":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='E1/Fiber'>E1/Fiber</option>" +
                        "<option value='SCTP'>SCTP</option>" +
                        "<option value='S-Other'>S-Other</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "Mobi TX":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='ZTE/HW/ER'>ZTE/HW/ER</option>" +
                        "<option value='E1 Configuration'>E1 Configuration</option>" +
                        "<option value='E1 Connector'>E1 Connector</option>" +
                        "<option value='E1 Cable'>E1 Cable</option>" +
                        "<option value='SCTP'>SCTP</option>" +
                        "<option value='M-Other'>M-Other</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "Other TX":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='DBN TX'>DBN TX</option>" +
                        "<option value='ETI TX'>ETI TX</option>" +
                        "<option value='Army TX'>Army TX</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "Env Effect":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='RAIN FD'>RAIN FD</option>" +
                        "<option value='Lightning'>Lightning</option>" +
                        "<option value='Flood'>Flood</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "Generator":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='Geny Fault'>Geny Fault</option>" +
                        "<option value='Geny Fuel'>Geny Fuel</option>" +
                        "<option value='Geny Maintaince'>Geny Maintaince</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "Other":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='Faults'>Faults</option>" +
                        "<option value='Acci'>Acci</option>" +
                        "<option value='Auto Up'>Auto Up</option>" +
                        "<option value='Highroom'>Highroom</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "BTS/NodeB":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='BRD'>BRD</option>" +
                        "<option value='FAN'>FAN</option>" +
                        "<option value='CBL'>CBL</option>" +
                        "<option value='BBU'>BBU</option>";
                    $('#fault_typel2txt').append(value);
                    break;
                case "No Acce":
                    $('#fault_typel2txt').empty();
                    var value = "<option value='Access issues'>Access issues</option>";
                    $('#fault_typel2txt').append(value);
                    break;
            }
        });

        function commentSubmit() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("id", $('#cellcodeid').val());
            form_data.append("comment", $('#commenttxt').val());
            form_data.append("userid", '{{Auth::id()}}');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (!($('#commenttxt').val() == null | $('#commenttxt').val() == '')) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'ml-2',
                    confirmButtonText: 'Yes, Add This!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: action + "api/cell-down/add/comment",
                            method: 'post',
                            data: form_data,
                            enctype: 'multipart/form-data',
                            processData: false,
                            contentType: false,
                            async: true,
                            success: function (result) {
                                if (result.code == 200) {
                                    swalWithBootstrapButtons.fire(
                                        'Success!',
                                        'Successfully Added Region Comment!',
                                        'success'
                                    )
                                    setInterval(function () {
                                        window.location = action + 'view-cell-down';
                                    }, 3000);
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'Cell Log is safe :)',
                                        'error'
                                    )
                                }

                            },
                            error: function (error) {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Cell Log is safe :)',
                                    'error'
                                )
                            }
                        });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Cell Log is safe :)',
                            'error'
                        )
                    }
                })
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Enter Comment Before Submit !', type: 'error'
                });
            }
        }

        function addAComment(id, code) {
            $('#cellcodeid').val(id);
            $('#cellcode').val(code);
            $('#modalCommentModal').modal({show: true});
        }

        function downloadReport() {
            window.location = action + "excel/cell-down-log";
        }

        var date = new Date();
        var currentDate = date.toISOString().substring(0, 10);
        document.getElementById('date_of_cleartxt').value = currentDate;

        function cellUpFunction() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("id", $('#idlog').val());
            form_data.append("fault_type", $('#fault_typetxt').val());
            form_data.append("fault_type2", $('#fault_typel2txt').val());
            form_data.append("remark_for_clear", $('#remark_for_cleartxt').val());
            form_data.append("date_of_clear", $('#date_of_cleartxt').val());
            form_data.append("fault_clear_action", $('#fault_clear_actiontxt').val());
            form_data.append("inoc_tl_name", $('#inoc_tl_name').val());
            form_data.append("cell_up_reported_by", '{{Auth::id()}}');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'ml-2',
                confirmButtonText: 'Yes, Cell Up!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: action + "api/cell-down/up",
                        method: 'post',
                        data: form_data,
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        async: true,
                        success: function (result) {
                            if (result.code == 200) {
                                swalWithBootstrapButtons.fire(
                                    'Success!',
                                    'Log has been Cell Up.',
                                    'success'
                                )
                                setInterval(function () {
                                    window.location = action + 'view-cell-down';
                                }, 3000);
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Cell Log is safe :)',
                                    'error'
                                )
                            }

                        },
                        error: function (error) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Cell Log is safe :)',
                                'error'
                            )
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Cell Log is safe :)',
                        'error'
                    )
                }
            })
        }

        /**
         * Update Function / Edit Function of Cell Down/UP Process
         **/

        function onClickSaveChanges() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("id", $('#celllogid').val());
            form_data.append("vender", $('#vendertxt').val());
            form_data.append("remark", $('#remarktxt').val());
            form_data.append("type", $('#typeselect').val());
            form_data.append("timedown", $('#timetxt').val());
            form_data.append("datedown", $('#datetxt').val());
            form_data.append("reportedto", $('#reportedto').val());
            form_data.append("sitename", $('#sitenametxt').val());
            form_data.append("downcellname", $('#downcellnametxt').val());
            form_data.append("region", $('#regiontxt').val());
            form_data.append("l1escalation", $('#l1Escalationtxt').val());
            form_data.append("l2escalation", $('#l2Escalationtxt').val());
            form_data.append("l3escalation", $('#l3Escalationtxt').val());
            form_data.append("reported_by", '{{Auth::id()}}');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (true) {
                $.ajax({
                    url: action + "api/cell-down/update",
                    method: 'post',
                    data: form_data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (result) {
                        if (result.code == 200) {
                            new PNotify({
                                title: 'Success notice', text: 'Cell Down Log Updated Successfully !', type: 'success'
                            });
                            setInterval(function () {
                                window.location = action + 'view-cell-down';
                            }, 3000);

                        } else {
                            new PNotify({
                                title: 'Danger notice', text: 'Cell Down Log Updated Fail !', type: 'error'
                            });
                        }

                    },
                    error: function (error) {
                        new PNotify({
                            title: 'Danger notice', text: 'Cell Down Log Updated Fail !', type: 'error'
                        });
                    }
                });
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Cell Down Log Updated Fail !', type: 'error'
                });
            }
        }

        /**
         * Load Edit View
         */

        function loadEditModalView(id) {
            $.ajax({
                url: action + "api/cell-down/log/single/" + id,
                method: 'GET',
                processData: false,
                contentType: false,
                async: true,
                success: function (result) {
                    for (let i in result) {
                        let respose = result[i];
                        let id = respose['id'];
                        let vender = respose['vender'];
                        let remark = respose['remark'];
                        let type = respose['type'];
                        let time_down_cell = respose['time_down_cell'];
                        let date_down_cell = respose['date_down_cell'];
                        let reported_to = respose['reported_to'];
                        let site_name = respose['site_name'];
                        let l_1escalation = respose['l_1escalation'];
                        let l_2escalation = respose['l_2escalation'];
                        let l_3escalation = respose['l_3escalation'];
                        let down_cell_name = respose['down_cell_name'];
                        let region = respose['region'];
                        $('#vendertxt').val(vender);
                        $('#remarktxt').val(remark);
                        $('#typeselect').val(type);
                        $('#timetxt').val(time_down_cell);
                        $('#datetxt').val(date_down_cell);
                        $('#reportedto').val(reported_to);
                        $('#sitenametxt').val(site_name);
                        $('#downcellnametxt').val(down_cell_name);
                        $('#regiontxt').val(region);
                        $('#l1Escalationtxt').val(l_1escalation);
                        $('#l2Escalationtxt').val(l_2escalation);
                        $('#l3Escalationtxt').val(l_3escalation);
                        $('#celllogid').val(id);
                    }
                    $('#editmodalload').modal({show: true});
                },
                error: function (error) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Cell Log is safe :)',
                        'error'
                    )
                }
            });

        }

        /**
         * Cell up click this function Button
         */

        function onClickCellUp(id) {
            $('#idlog').val(id);
            $('#modalcellup').modal({show: true});
        }

        /**
         * Load Single View of (id) Cell Down Log
         */

        function loadSingleView(id) {
            window.location = action + "cell-down/view/0/" + id;
        }

        /**
         * Delete Cell Down Log Data
         * @param id
         */

        function onClickDelete(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'ml-2',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: action + "api/cell-down/delete/" + id,
                        method: 'GET',
                        processData: false,
                        contentType: false,
                        async: true,
                        success: function (result) {
                            if (result.code == 200) {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Log has been deleted.',
                                    'success'
                                )
                                setInterval(function () {
                                    window.location = action + 'view-cell-down';
                                }, 3000);
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Your imaginary Log is safe :)',
                                    'error'
                                )
                            }

                        },
                        error: function (error) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Your imaginary Log is safe :)',
                                'error'
                            )
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary Log is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
