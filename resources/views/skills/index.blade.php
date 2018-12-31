@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">My Skills</div>
                <div class="card-body">
                    <canvas id="skillsDoughnutChart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-header">My Skills</div>
                <div>
                   <table class="table" style="margin-bottom:0">
                       <tbody>
                           @foreach($mine as $item)
                               <tr>
                                   <td>{{ $item->skill->title }}</td>
                                   <td>{{ round(($item->skill_count / count($mine)) * 100) }}%</td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Upcoming Recertifications
                </div>
                <div>
                    <table class="table" style="margin-bottom:0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recertifications as $recertification)
                                <tr>
                                    <td><a href="{{ route('courses.show', $recertification->course) }}">{{ $recertification->course->title }}</a></td>
                                    <td>{{ $recertification->recertify_at->format('Y-m-d') }}</td>
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

@section('footer')
    <script type="text/javascript">
        function buildChart()
        {
            var ctx = document.getElementById("skillsDoughnutChart");

            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            @foreach($mine as $item)
                                {{ round(($item->skill_count / count($mine)) * 100) }},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($mine as $item)
                                '{{ $item->skill->color }}',
                            @endforeach
                        ]
                    }],
                    labels: [
                        @foreach($mine as $item)
                            '{{ $item->skill->title }}',
                        @endforeach
                    ]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            title: function (tooltipItem, data) { return data.labels[tooltipItem[0].index]; },
                            label: function (tooltipItem, data) {
                                var amount = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return amount + '%';
                            },
                            //footer: function(tooltipItem, data) { return 'Total: 100 planos.'; }
                        }
                    },
                }
            });
        }

        (function(){

           $(document).ready(function(){

               buildChart();

           });

        })();
    </script>
@endsection
