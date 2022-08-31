@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>

@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
        @if(Auth::user()->usertype==1 || Auth::user()->usertype==2 )
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex">
                    <select class="form-control" id="selectreportType">
                        <option value="Today">Today</option>
                        <option value="Week">Weekly</option>
                        <option value="Month">Monthly</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" onclick="downloadReport()">
                    <i class="btn-icon-prepend" data-feather="download"></i>
                    Download Report
                </button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Cell Up Log Count</h6>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{$up}}</h3>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Cell Down Log Count</h6>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{$down}}</h3>

                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Cell Log Count </h6>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{$total}}</h3>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex">
            <input type="date" id="fromdate" class="form-control" style="color: white">
        </div>
        <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex">
            <input type="date" id="todate" class="form-control" style="color: white">
        </div>
        <button type="button" onclick="loadChartData()" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="search"></i>
            Search
        </button>
    </div>
    <br>
    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Line chart</h6>
                    <canvas id="linechart"></canvas>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs.js') }}"></script>
    <script>

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth()+1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        let currentdate=new Date();
        let cuurentdatestring=formatDate(currentdate);
        currentdate.setMonth(currentdate.getMonth()-1);
        let cuurentdatebefromstring=formatDate(currentdate);
        $('#fromdate').val(cuurentdatebefromstring);
        $('#todate').val(cuurentdatestring);

        function downloadReport() {
            let selectval = $('#selectreportType').val();
            window.location = action + "excel/total-cell-log/" + selectval;
        }

        myChart = new Chart($('#linechart'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        label: "ZTE",
                        borderColor: "#7ee5e5",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    {
                        data: [],
                        label: "Huawei",
                        borderColor: "#f77eb9",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    },
                    {
                        data: [],
                        label: "Total",
                        borderColor: "#82f77e",
                        backgroundColor: "rgba(0,0,0,0)",
                        fill: false
                    }
                ]
            }
        });

        function updateChart(chart, data) {
            chart.data.labels = data.label;
            chart.data.datasets = [data.huaweiobj, data.zteobj, data.totalobj];
            chart.update();
        }

        function loadChartData() {
            $.ajax({
                url: action + 'api/report/dashboard/' + $('#fromdate').val() + "/" + $('#todate').val(),
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: true,
                dataType: "json"
            }).done(function (resp) {
                let chartLabel = [];
                let chartHuaweiData = [];
                let chartZTEData = [];
                let chartTotalData = [];
                for (let data of resp) {
                    let date_down = data['date_down'];
                    chartLabel.push(date_down);
                    let tot=0;
                    let huawei = data['huawei'];
                    let zte = data['zte'];
                    let huaval=parseInt(huawei);
                    let zteval=parseInt(zte);
                    chartHuaweiData.push(huaval);
                    chartZTEData.push(zteval);
                    tot=huaval+zteval;
                    chartTotalData.push(tot);
                }

                let ZTEobj = {
                    data: chartZTEData,
                    label: "ZTE",
                    borderColor: "#7ee5e5",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }

                let totalobj = {
                    data: chartTotalData,
                    label: "Total",
                    borderColor: "#d91cd0",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }

                let Huaweiobj = {
                    data: chartHuaweiData,
                    label: "Huawei",
                    borderColor: "#159797",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }


                updateChart(myChart, {
                    label: chartLabel,
                    huaweiobj: Huaweiobj,
                    zteobj: ZTEobj,
                    totalobj: totalobj
                })
            });
        }

        loadChartData();

    </script>
@endpush
