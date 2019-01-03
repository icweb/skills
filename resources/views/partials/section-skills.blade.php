@foreach($skills as $skill)
    <span style="color:{{ $skill->color }}" class="skill-badge"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>
@endforeach