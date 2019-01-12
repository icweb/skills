@foreach($skills as $skill)
    <form action="{{ route('library.search') }}" method="post" style="display:inline-block" target="_blank">
        @csrf
        <input type="hidden" name="skill" value="{{ $skill->title }}">
        <button type="submit" class="btn btn-default mr-5 mb-10" style="color:{{ $skill->color }}"><em class="fa fa-circle-o"></em> {{ $skill->title }}</button>
    </form>
    {{--<span style="color:{{ $skill->color }}" class="skill-badge"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>--}}
@endforeach