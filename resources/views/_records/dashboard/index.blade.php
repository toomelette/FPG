@php
    $free = 0;
    $total = 0;
    if(PHP_OS == "WINNT"){
        $free =disk_free_space("/home");
        $total =disk_total_space("/home");
    }else{
        $free = disk_free_space("/home");
        $total =disk_total_space("/home");
    }
@endphp

@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Dashboard</x-slot:title>

    </x-adminkit.html.page-title>

    <div class="row mb-3">
        <div class="col-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Documents Uploaded</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-file-pdf"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($all_documents)}}</h1>

            </x-adminkit.html.card>
        </div>
        <div class="col-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Emails sent</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-mail-bulk"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($all_emails_sent)}}</h1>

            </x-adminkit.html.card>
        </div>
        <div class="col-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Contacts</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($all_contacts)}}</h1>

            </x-adminkit.html.card>
        </div>
        <div class="col-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Average Emails Sent per Week</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-envelope"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($avg_sent_by_week)}}</h1>
            </x-adminkit.html.card>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <x-adminkit.html.card style="min-height: 400px">
                <x-adminkit.html.alert type="info mb-1" body-class="p-1 text-center text-strong" :dismissible="false" :with-icon="false">
                    Documents uploaded monthly
                </x-adminkit.html.alert>

                <div class="chart chart-md">
                    <canvas id="documents_per_month"></canvas>
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-2">
            <x-adminkit.html.card style="min-height: 400px">
                <x-adminkit.html.alert type="warning mb-1" body-class="p-1 text-center text-strong" :dismissible="false" :with-icon="false">
                    Storage
                </x-adminkit.html.alert>

                <div class="chart chart-md">
                    <canvas id="storage_graph"></canvas>
                </div>
                <div class="text-center">
                    <strong>
                        {{number_format(Helper::convertFromBytes($free,'gb'),2)}}GB free of {{number_format(Helper::convertFromBytes($total,'gb'),2)}}GB
                    </strong>
                </div>
            </x-adminkit.html.card>
        </div>
    </div>
@endsection


@section('modals')

@endsection


@section('scripts')
    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("documents_per_month").getContext("2d");
            var gradientLight = ctx.createLinearGradient(0, 0, 0, 225);
            gradientLight.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradientLight.addColorStop(1, "rgba(215, 227, 244, 0)");
            var gradientDark = ctx.createLinearGradient(0, 0, 0, 225);
            gradientDark.addColorStop(0, "rgba(51, 66, 84, 1)");
            gradientDark.addColorStop(1, "rgba(51, 66, 84, 0)");
            // Line chart
            new Chart(document.getElementById("documents_per_month"), {
                type: "line",
                data: {
                    labels: [
                        @foreach($documents_per_month as $key=>$data)
                            '{{date('F Y',strtotime($key))}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Uplaoded",
                        fill: true,
                        backgroundColor: window.theme.id === "light" ? gradientLight : gradientLight,
                        borderColor: window.theme.primary,
                        data: [
                            @foreach($documents_per_month as $data)
                                    {{$data}},
                            @endforeach
                        ]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        intersect: false
                    },
                    hover: {
                        intersect: true
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            reverse: true,
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 100
                            },
                            display: true,
                            borderDash: [3, 3],
                            gridLines: {
                                color: "rgba(0,0,0,0.0)",
                                fontColor: "#fff"
                            }
                        }]
                    }
                }
            });


            // Pie chart
            new Chart(document.getElementById("storage_graph"), {
                type: "pie",
                data: {
                    labels: [
                        'Used',
                        'Free',
                    ],
                    datasets: [{
                        data: [
                            {{$total-$free}},{{$free}}
                            ],
                        backgroundColor: [
                            '#fef1d5',
                            '#d1ecf1',
                        ],
                        borderWidth: 5,
                        borderColor: window.theme.white
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 70
                }
            });
        });



    </script>
@endsection