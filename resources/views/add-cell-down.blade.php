@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Cell Down Log Add</h6>
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
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
                                    <textarea id="remarktxt" class="form-control" placeholder="Enter Remark"></textarea>
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
                                        <option value="Hua - 3G">Hua - 3G</option>
                                        <option value="ZTE - 3G">ZTE - 3G</option>
                                    </select>
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Time of Down Cell</label>
                                    <input id="timetxt" type="time" class="form-control"  placeholder="Enter Time of Down Cell">
                                </div>
                            </div><!-- Col -->

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Date</label>
                                    <input id="datetxt" type="date" class="form-control" >

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Reported To</label>
                                    <input id="reportedto" type="text" class="form-control" placeholder="Enter Reported To">
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Site Name</label>
                                    <input id="sitenametxt" type="text" class="form-control" placeholder="Enter Site Name">
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">L1 Escalation</label>
                                    <input id="l1Escalationtxt" type="text" class="form-control" placeholder="Enter L1 Escalation">
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Down Cell Name</label>
                                    <input id="downcellnametxt" type="text" class="form-control" placeholder="Enter Down Cell Name">
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">L2 Escalation</label>
                                    <input id="l2Escalationtxt" type="text" class="form-control" placeholder="Enter L2 Escalation">
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
                                    <input id="l3Escalationtxt" type="text" class="form-control" placeholder="Enter L3 Escalation">
                                </div>
                            </div><!-- Col -->
                        </div>

                    </form>
                    <button type="button" id="submitbtn" onclick="onclickSubmit()" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
    <!-- Pnotify js -->
    <script src="{{asset('assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dragula.js') }}"></script>
    <script>

        var date = new Date();
        var currentDate = date.toISOString().substring(0,10);
        var currentTime = date.toISOString().substring(11,16);

        document.getElementById('datetxt').value = currentDate;
        document.getElementById('timetxt').value = currentTime;

        /**
         * Function For add Cell Down Log
         */

        function onclickSubmit(){
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("vender", $('#vendertxt').val());
            form_data.append("remark", $('#remarktxt').val());
            form_data.append("type", $('#typeselect').val());
            form_data.append("timedown", $('#timetxt').val());
            form_data.append("datedown",$('#datetxt').val() );
            form_data.append("reportedto",$('#reportedto').val() );
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
                    url: action + "api/cell-down/add",
                    method: 'post',
                    data: form_data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (result) {
                        if (result.code==200) {
                            new PNotify( {
                                title: 'Success notice', text: 'Cell Down Added Successfully !', type: 'success'
                            });
                            setInterval(function(){ window.location = action + 'view-cell-down'; }, 3000);

                        }else{
                            new PNotify( {
                                title: 'Danger notice', text: 'Cell Down Added Fail !', type: 'error'
                            });
                        }

                    },
                    error: function (error) {
                        new PNotify( {
                            title: 'Danger notice', text: 'Cell Down Added Fail !', type: 'error'
                        });
                    }
                });
            } else {
                new PNotify( {
                    title: 'Danger notice', text: 'Cell Down Added Fail !', type: 'error'
                });
            }
        }

    </script>
@endpush
