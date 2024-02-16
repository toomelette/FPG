@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Dashboard



        </h1>
    </section>
    <?php
    $free = 0;
    $total = 0;
    if(PHP_OS == "WINNT"){
        $free =disk_free_space("/home");
        $total =disk_total_space("/home");
    }else{
        $free = disk_free_space("/home");
        $total =disk_total_space("/home");
    }

    ?>

    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{number_format($all_documents)}}</h3>
                        <p>No. of Documents on record</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    {{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{number_format($all_emails_sent)}}</h3>
                        <p>No. of Emails Sent</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope-o"></i>
                    </div>
                    {{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{number_format($all_contacts)}}</h3>

                        <p>Contacts</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    {{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{number_format($avg_sent_by_week)}}</h3>

                        <p>Average Emails Sent per Week</p>
                    </div>
                    <div class="icon">
                        <i class="fa  fa-calendar-check-o"></i>
                    </div>
                    {{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <!-- ./col -->
        </div>

        @include('dashboard.home.announcement')

        <div class="row">
            <div class="col-md-10">
                <div class="panel">
                    <div class="panel-body">
                        <center><label>Documents Uploaded (Monthly)</label></center>
                        <hr class="no-margin">
                        <canvas id="documents_per_month" width="400" height="82"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pull-right">
                    <div class="panel">
                        <div class="panel-body">
                            <center><label>Storage</label></center>
                            <hr class="no-margin">
                            <canvas id="storage_graph" width="230" height="50"></canvas>
                            <br>
                            <center>
                                <label>{{__dataType::convert_bytes($free)}} of {{__dataType::convert_bytes($total)}}</label>
                            </center>
                        </div>

                    </div>


                </div>
            </div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <center><label>Emails per contact</label></center>
                        <hr class="no-margin">
                        <div class="col-md-4">

                            <canvas id="documents_sent_graph" width="400" height="390"></canvas>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered table-condensed" id="emails_per_contact_table">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Applicants</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($emails_per_contact->count() > 0)
                                    @foreach($emails_per_contact as $data)
                                        <tr>
                                            <td>

                                                {{$data->emailContact->name ?? ''}}

                                                {{$data->employee->fullname ?? ''}}
                                                |
                                                <span class="small">{{$data->email}}</span>

                                            </td>
                                            <td class="text-center">
                                                {{number_format($data->count)}}
                                            </td>
                                        </tr>
                                    @endforeach


                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection




@section('scripts')
    <script type="text/javascript">
        $("document").ready(function () {

            $("#emails_per_contact_table").DataTable({
                "bLengthChange": false,
            });

            var storage_graph = new Chart($("#storage_graph"), {
                type: 'doughnut',
                data: {
                    datasets: [
                        {
                            data: [
                               {{$total-$free}},{{$free}}
                            ],
                            backgroundColor:[
                                'rgb(232, 152, 5)',
                                'rgb(68, 235, 193)',
                            ],
                        }
                    ],
                    labels:[
                        'Used',
                        'Free',
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: false,
                        }
                    }
                },
            });


            var documents_sent_graph = new Chart($("#documents_sent_graph"), {
                type: 'pie',
                data: {
                    datasets: [
                        {
                            data: [
                                @foreach($emails_per_contact as $data)
                                    {{$data->count}},
                                @endforeach
                            ],
                            backgroundColor:[
                                @foreach($emails_per_contact as $data)
                                    'rgb({{mt_rand(1,255)}},{{mt_rand(1,255)}},{{mt_rand(1,255)}})',
                                @endforeach


                            ],
                        }
                    ],
                    labels:[
                        @foreach($emails_per_contact as $data)
                            '{{$data->emailContact->name ?? ($data->employee->fullname ?? $data->email)}}',
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,

                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: false,
                        }
                    }
                },
            });

            var documents_per_month = new Chart($("#documents_per_month"), {
                type: 'line',
                data: {
                    datasets: [
                        {
                            data: [
                                @foreach($documents_per_month as $data)
                                    {{$data}},
                                @endforeach
                            ],
                            borderColor : 'rgb(75, 192, 192)',
                            fill: false,

                        }
                    ],
                    labels:[
                        @foreach($documents_per_month as $key=>$data)
                            '{{date('F Y',strtotime($key))}}',
                        @endforeach
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            type: 'logarithmic',
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 20
                            }
                        }]
                    },
                    responsive: true,
                    plugins: {
                        zoom: {
                            zoom: {
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'xy',
                            }
                        },
                        legend: {
                            display: false,
                        },
                        title: {
                            display: false,
                            text: 'Chart.js Pie Chart'
                        }
                    }
                },
            });

        });

        $(document).ready(function () {
            @if(request()->has('initiator') && request('initiator') != '')
            $("#hide_show_{{request('initiator')}}").trigger('click');
            setTimeout(function () {
                introJs().start();
            },500);
            @endif
        })

    </script>

@endsection