<div class="card">
    <div class="card-header bg-danger text-white">
        Delete {{ $title }}
    </div>
    <div class="card-body">
        <p>{{ $body }} You will have a chance to confirm this decision.</p>
        <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#{{ $modal }}"><em class="fa fa-trash-o"></em> Delete {{ $title }}</button>
    </div>
</div>