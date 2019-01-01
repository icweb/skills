@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-40">{{ $user->name }}'s Skills</h2>
        </div>
        @if(count($mine))
            <div class="col-md-8">
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">Skills Chart</div>
                    <div class="card-body">
                        <canvas id="skillsDoughnutChart" width="800" height="450"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">Breakdown</div>
                    <div>
                       <table class="table no-mb">
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
        @else
            <div class="col-12">
                <h4 class="mt-40">No Skills Found</h4>
                Check back after you've completed your first course.
            </div>
        @endif
        @if(count($late_receritifcations))
            <div class="col-12" style="margin-bottom: 20px">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Late Recertifications
                    </div>
                    <div>
                        <table class="table no-mb">
                            <thead>
                            <tr>
                                <th>Course</th>
                                <th>Due</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($late_receritifcations as $late_recertification)
                                <tr>
                                    <td><a href="{{ route('courses.show', $late_recertification->course) }}">{{ $late_recertification->course->title }}</a></td>
                                    <td>{{ $late_recertification->recertify_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if(count($upcoming_receritifcations))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Upcoming Recertifications
                        </div>
                        <div>
                            <table class="table no-mb">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Due</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($upcoming_receritifcations as $upcoming_recertification)
                                    <tr>
                                        <td><a href="{{ route('courses.show', $upcoming_recertification->course) }}">{{ $upcoming_recertification->course->title }}</a></td>
                                        <td>{{ $upcoming_recertification->recertify_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        @endif
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
