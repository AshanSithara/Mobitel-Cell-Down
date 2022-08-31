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
            <h4 class="mb-3 mb-md-0">Region Section Report</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex">
                <input type="date" id="searchdate" class="form-control" style="color: white">
            </div>
            <button type="button" onclick="loadChartData()" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="search"></i>
                Search
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <canvas id="chartjsBar"></canvas>
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
    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dragula.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
    <script>

        function updateChart(chart, data) {
            chart.data.labels = data.label;
            chart.data.datasets = [data.chartdata];
            chart.update();
        }

        let chart = new Chart($("#chartjsBar"), {
            type: 'bar',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                legend: {display: false},
            }
        });


        function loadChartData() {
            let searchdate = $('#searchdate').val();
            $.ajax({
                url: action + 'api/report/region-report/' + searchdate,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: true,
                dataType: "json"
            }).done(function (resp) {
                let chartLabel = [];
                let valData = [];
                for (let data of resp) {
                    let name = data['name'];
                    chartLabel.push(name);
                    let val = data['value'];
                    valData.push(val);
                }


                let cellobj = {
                    label: "Region Down Count",
                    backgroundColor: ["#b1cfec", "#1ba3a3", "#c99226", "#cb1246", "#5f7a62", "#3c4d16", "#21c4c2"],
                    data: valData
                }

                updateChart(chart, {
                    label: chartLabel,
                    chartdata: cellobj
                })
            });
        }

    </script>
@endpush
