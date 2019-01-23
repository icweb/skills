@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid" style="padding: 2rem 4rem 2rem 4rem;margin-bottom:0;color:#ffffff;background-color:{{ $course->color }}">
        <h1 class="display-4" style="font-size:36px;">{{ $course->title }}</h1>
        <div class="card-completion mb-20" style="color: #ffffff !important;"><em class="fa fa-clock-o"></em> Completion Time: {{ $course->completionTime() }}</div>
        <div>
            <a href="{{ route('courses.show', $course) }}" class="btn btn-lg text-white" style="border: 1px solid #ffffff"><em class="fa fa-times"></em> Exit Manage Mode</a>
        </div>
    </div>
    <div class="mt-40" style="padding: 10px 75px;">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-40">
                    <div class="card-header">
                        Actions
                    </div>
                    <div class="card-body">
                        <ul>
                            {{--<li><a href="javascript:void(0)" id="assignUser">Assign User</a></li>--}}
                            <li><a href="">Take Attendance</a></li>
                            <li><a href="">Send Email</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Reports
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><a href="">Class Roster</a></li>
                            <li><a href="">Completion Certificates</a></li>
                            <li><a href="">Completion by User</a></li>
                            <li><a href="">Completion by Lessons</a></li>
                            <li><a href="">Completion by Lectures</a></li>
                            @if($course->recertify_interval)
                                <li><a href="">Upcoming Recertifications</a></li>
                                <li><a href="">Late Recertifications</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <em class="fa fa-filter"></em>
                                Filter
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'all']) }}">
                                    @if($users_view === 'all')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    All Users
                                </a>
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'incomplete']) }}">
                                    @if($users_view === 'incomplete')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    Incomplete
                                </a>
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'completed']) }}">
                                    @if($users_view === 'completed')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    Completed
                                </a>
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'due_soon']) }}">
                                    @if($users_view === 'due_soon')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    Due Soon
                                </a>
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'late']) }}">
                                    @if($users_view === 'late')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    Late
                                </a>
                                <a class="dropdown-item" href="{{ route('courses.manage', [$course, 'u_view' => 'recent']) }}">
                                    @if($users_view === 'recent')
                                        <em class="fa fa-check"></em>
                                    @endif
                                    Recently Added
                                </a>
                            </div>
                        </div>
                        Assigned Users
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Due</th>
                                <th>Completed</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($course_user as $item)
                                <tr>
                                    <td>{{ $item->assignedUser->name }}</td>
                                    <td>{{ $item->due_at->format('m/d/Y') }}</td>
                                    <td>
                                        @if($item->completed_at)
                                            {{ $item->completed_at->format('m/d/Y') }}
                                        @else
                                            <a href="javascript:void(0)" class="edit-assignment"
                                               onclick="Course.showEditAssignmentModal($(this))"
                                               data-name="{{ $item->assignedUser->name }}"
                                               data-completed="{{ $item->completed_at ? $item->completed_at->format('Y-m-d') : '' }}"
                                               data-due="{{ $item->due_at ? $item->due_at->format('Y-m-d') : '' }}"
                                               data-edit-form="{{ route('courses.assign.update', [$course, $item->id]) }}"
                                            >Complete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" id="assignUser" class="btn btn-success"><em class="fa fa-plus"></em> Assign User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="assign-user-modal" tabindex="-1" role="dialog">
        <form action="{{ route('courses.assign', $course) }}" method="POST">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign User to Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="assigned_users">Select one or more users in the field below to assign them to this course.</label>
                            <select name="assigned_users[]" id="assigned_users" class="form-control multi-picker" multiple required>
                                @foreach($all_users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group editRecordGroup">
                            <label for="newAssignmentDue">Due At <small class="small text-danger">*</small></label>
                            <input type="date" class="form-control" id="newAssignmentDue" name="due_at" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><em class="fa fa-save"></em> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal" id="edit-assignment-modal" tabindex="-1" role="dialog">
        <form action="" method="POST" id="edit-assignment-form">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Assignment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Edit Type</label><br>
                            <input type="radio" name="editType" value="edit" checked> Edit Record<br>
                            <input type="radio" name="editType" value="delete"> Delete Record<br>
                        </div>
                        <div class="form-group editRecordGroup">
                            <label for="assignmentUser">Assigned User</label>
                            <input type="text" class="form-control" disabled readonly="readonly" id="assignmentUser">
                        </div>
                        <div class="form-group editRecordGroup">
                            <label for="assignmentDue">Due At</label>
                            <input type="date" class="form-control" id="assignmentDue" disabled readonly="readonly">
                        </div>
                        <div class="form-group editRecordGroup">
                            <label for="assignmentCompleted">Completed At <small class="small text-danger">*</small></label>
                            <input name="completed_at" type="date" class="form-control" id="assignmentCompleted">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><em class="fa fa-save"></em> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Course = {

            showAssignUserModal: function(){

                $('#assign-user-modal').modal('show');

            },

            showEditAssignmentModal: function(obj){

                var name = obj.attr('data-name');
                var due = obj.attr('data-due');
                var completed = obj.attr('data-completed');
                var editForm = obj.attr('data-edit-form');

                $('#assignmentUser').val(name);
                $('#assignmentDue').val(due);
                $('#assignmentCompleted').val(completed);

                $('#edit-assignment-form').attr('action', editForm);

                $('[name=editType][value=edit]').prop('checked', true);
                $('.editRecordGroup').show();

                $('#edit-assignment-modal').modal('show');

            },

            created: function(){

                $('.table').dataTable();

                $(".multi-picker").selectpicker({dropupAuto: false, maxOptions:100, liveSearch: true});

                $('#assignUser').click(Course.showAssignUserModal);

                $('[name=editType]').on('change', function(){

                    if($(this).val() === 'edit')
                    {
                        $('.editRecordGroup').show();
                    }
                    else
                    {
                        $('.editRecordGroup').hide();
                    }

                });

            }

        };

        $(document).ready(function(){

            Course.created();

            if(window.location.hash === '#')
            {
               //
            }

        });

    </script>
@endsection