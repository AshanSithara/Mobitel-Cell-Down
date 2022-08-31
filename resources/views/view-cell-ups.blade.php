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
            <h4 class="mb-3 mb-md-0">View Cell Ups Details</h4>
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
                        <button type="button" class="btn btn-danger btn-icon-text" onclick="deleteSelectedData()">
                            <i class="btn-icon-prepend" data-feather="delete"></i>
                            DELETE SELECTED
                        </button>
                    @endif
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
                                    <td><span class="badge badge-success">UP</span></td>
                                    <td class="text-xl-center">
                                        <div class="user-btn-wrapper">

                                            <button type="button" onclick="loadSingleView({{$downs_data->id}})"
                                                    class="btn btn-primary btn-primary">View
                                            </button>
                                            @if(Auth::user()->usertype==1 || Auth::user()->usertype==2)
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
                                        window.location = action + 'view-cell-up';
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

        function downloadReport() {
            window.location = action + "excel/cell-up-log";
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
            form_data.append("reported_by", {{Auth::id()}});

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
                                window.location = action + 'view-cell-up';
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
         * Load Single View of (id) Cell Down Log
         */

        function loadSingleView(id) {
            window.location = action + "cell-down/view/1/" + id;
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
                                    window.location = action + 'view-cell-up';
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
