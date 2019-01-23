<form action="{{ isset($course) ? route('lectures.complete', [$course, $lesson, $lecture]) : '#' }}" method="post">
    @csrf

    <div class="card mb-30">
        <div class="card-body text-right">
            <button type="submit" class="btn btn-success btn-lg">Next <em class="fa fa-chevron-right"></em></button>
        </div>
    </div>

</form>

<div class="card mb-30">
    <div class="card-body articleBodyHtml">
        {!! nl2br($body) !!}
        <br>
        <form action="{{ route('lectures.download', $lecture) }}" target="_blank" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-download"></em> Download File</button>
        </form>
    </div>

</div>