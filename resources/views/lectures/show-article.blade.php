<form action="{{ isset($course) ? route('lectures.complete', [$course, $lesson, $lecture]) : '#' }}" method="post">
    @csrf

    <div class="card mb-30">
        <div class="card-body text-right">
            <button type="submit" class="btn btn-success btn-lg">Next <em class="fa fa-chevron-right"></em></button>
        </div>
    </div>


    <div class="card mb-30">
        <div class="card-body articleBodyHtml">
            {!! nl2br($body) !!}
        </div>
    </div>

    <div class="card mb-30">
        <div class="card-body text-right">
            <button type="submit" class="btn btn-success btn-lg">Next <em class="fa fa-chevron-right"></em></button>
        </div>
    </div>

</form>
