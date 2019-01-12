<div class="card mb-40">
    <div class="card-header pr-10">
        <a href="{{ route('lessons.edit', [$course, $lesson]) }}" class="btn btn-warning btn-sm pull-right show-on-lessons-edit"><em class="fa fa-pencil"></em> Edit</a>
        <a href="{{ route('lectures.create', [$course, $lesson]) }}" class="btn btn-success btn-sm pull-right show-on-lessons-edit mr-10"><em class="fa fa-plus"></em> Add Lecture</a>
        {{ $lesson->title }}
    </div>
    <div>
        <table class="table no-mb">
            <tbody>
            @foreach($lesson->assignedLectures()->orderBy('position', 'asc')->get() as $lecture)
                <tr>
                    <td style="width:50px;">
                        @if($lecture->lecture->type === 'Quiz')
                            <em class="fa fa-play-circle"></em>
                        @elseif($lecture->lecture->type === 'Download')
                            <em class="fa fa-download"></em>
                        @elseif($lecture->lecture->type === 'Video')
                            <em class="fa fa-video-camera"></em>
                        @else
                            <em class="fa fa-file-o"></em>
                        @endif
                    </td>
                    <td style="width:100px;">
                        <span class="hide-on-lessons-edit {{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">{{ $lecture->lecture->type }}</span>
                        <span class="show-on-lessons-edit">{{ $lecture->lecture->type }}</span>

                    </td>
                    <td>
                        <span class="hide-on-lessons-edit {{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">
                            <a href="{{ route('lectures.show', [$course, $lesson, $lecture->lecture]) }}">{{ $lecture->lecture->title }}</a>
                        </span>
                        <span class="show-on-lessons-edit">{{ $lecture->lecture->title }}</span>

                    </td>
                    <td class="text-right">
                        <div class="hide-on-lessons-edit">
                            @if(count($lecture->lecture->completionHistory()) > 0)

                                @if(strtotime($lecture->lecture->completionHistory()[0]->recertify_at) > time())
                                    <span class="text-danger">
                                        Recertify due {{ $lecture->lecture->completionHistory()[0]->recertify_at->format('Y-m-d') }}
                                    </span>
                                @else
                                    <span class="text-success">
                                        Completed {{ $lecture->lecture->completionHistory()[0]->completed_at->format('Y-m-d') }}
                                    </span>
                                @endif

                            @endif
                        </div>
                    </td>
                    <td class="show-on-lessons-edit">
                        <a href="{{ route('lectures.edit', [$course, $lesson, $lecture->lecture]) }}" class="btn btn-warning btn-sm pull-right"><em class="fa fa-pencil"></em> Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>