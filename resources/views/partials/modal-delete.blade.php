<div class="modal" id="{{ $id }}" tabindex="-1" role="dialog">
    <form action="{{ $form }}" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-top: 4px solid red !important">
                <div class="modal-header">
                    <h5 class="mb-0">Confirm Delete {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="alert alert-danger">{{ $message }}</div>
                    @if($table)
                        <table class="table mb-0">
                            <tr>
                                <td style="width: 130px;">
                                    <input type="radio" name="delete_type" value="soft" checked>
                                    <b>{{ $table_data['soft']['title'] }}</b>
                                </td>
                                <td>
                                    {{ $table_data['soft']['message'] }}<br>
                                    <em class="fa fa-check text-success"></em> <b class="text-success">If you are unsure, select this option.</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="delete_type" value="hard">
                                    <b>{{ $table_data['hard']['title'] }}</b>
                                </td>
                                <td>
                                    {{ $table_data['hard']['message'] }}<br>
                                    <em class="fa fa-warning text-danger"></em> <b class="text-danger">This is destructive and cannot be reversed.</b>
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><em class="fa fa-trash-o"></em> Delete</button>
                    {{--@include('partials.ui.button', ['type' => 'button', 'label' => 'Cancel', 'dismissModal' => true])--}}
                    {{--@include('partials.ui.button', ['type' => 'submit', 'class' => 'danger', 'icon' => true, 'iconClass' => 'trash-o', 'label' => 'Delete'])--}}
                </div>
            </div>
        </div>
    </form>
</div>