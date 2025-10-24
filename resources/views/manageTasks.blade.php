@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4" name="header">
            <h2 class=" fw-semibold fs-4 text-dark mb-0">Task Manager</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal"> + Add Task</button>
        </div>

        <div class="row mt-5 ">
            <!-- Critical Tasks -->
            <div class="col-md-3">
                <div class="card  text-white mb-4 border border-danger">
                    <div class="card-header bg-danger">Critical</div>
                    <div class="card-body" id="critical-tasks">
                        @forelse($tasks['critical'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <span>{{ $task->created_at->format('M d Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-light-50">No critical tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- High Tasks -->
            <div class="col-md-3">
                <div class="card  text-dark mb-4 border border-high">
                    <div class="card-header bg-high">High</div>
                    <div class="card-body" id="high-tasks">
                        @forelse($tasks['high'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <span>{{ $task->created_at->format('M d Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">No high priority tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Medium Tasks -->
            <div class="col-md-3">
                <div class="card  text-dark mb-4 border border-warning">
                    <div class="card-header bg-warning">Medium</div>
                    <div class="card-body" id="medium-tasks">
                        @forelse($tasks['medium'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <span>{{ $task->created_at->format('M d Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">No medium priority tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Low Tasks -->
            <div class="col-md-3">
                <div class="card  text-white mb-4 border border-success">
                    <div class="card-header  bg-success">Low</div>
                    <div class="card-body" id="low-tasks">
                        @forelse($tasks['low'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <span>{{ $task->created_at->format('M d Y') }}</span>

                                </div>
                            </div>
                        @empty
                            <p class="text-center text-light-50">No low priority tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" autocomplete="off" action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority Level</label>
                            <select class="form-select" name="priority_level" required>
                                <option value="">Select Priority</option>
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subtasks</label>
                            <div id="create-subtasks-container"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addCreateSubtask">
                                <i class="bi bi-plus"></i> Add Subtask
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="saveTask">
                        <span class="spinner-border spinner-border-sm d-none"></span> Save Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Task Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <p id="view-title" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p id="view-description" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Priority</label>
                        <p id="view-priority_level" class="form-control-plaintext text-capitalize"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Subtasks</label>
                        <ul id="view-subtasks" class="list-group small"></ul>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Created At</label>
                        <p id="view-created-at" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Updated At :</label>
                        <p id="view-updated-at" class="form-control-plaintext"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="editTaskBtn">
                        <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                            </svg></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Task Modal -->
    <div class="modal fade" id="EditTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" autocomplete="off" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select class="form-select" id="edit-priority_level" name="priority_level">
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subtasks</label>
                            <div id="edit-subtasks-container"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addEditSubtask">
                                <i class="bi bi-plus"></i> Add Subtask
                            </button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="deleteTask">
                        <span class="spinner-border spinner-border-sm d-none"></span> Delete
                    </button>
                    <button class="btn btn-primary" id="updateTask">
                        <span class="spinner-border spinner-border-sm d-none"></span> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(function() {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let createSubIndex = 0;
            let editSubIndex = 0;

            // Add / Remove Subtasks (Create)
            $('#addCreateSubtask').click(function() {
                createSubIndex++;
                $('#create-subtasks-container').append(`
            <div class="subtask-row d-flex align-items-center mb-2">
                <input type="text" class="form-control me-2"
                       name="subtasks[${createSubIndex}][text]"
                       placeholder="Enter subtask">
                <button type="button" class="btn btn-sm btn-danger remove-subtask">×</button>
            </div>
        `);
            });

            // Add / Remove Subtasks (Edit)
            $('#addEditSubtask').click(function() {
                editSubIndex++;
                $('#edit-subtasks-container').append(`
            <div class="subtask-row d-flex align-items-center mb-2">
                <input type="hidden" name="subtasks[${editSubIndex}][completed]" value="0">
                <input type="checkbox" class="me-2" name="subtasks[${editSubIndex}][completed]" value="1">
                <input type="text" class="form-control me-2" name="subtasks[${editSubIndex}][text]" placeholder="Enter subtask">
                <button type="button" class="btn btn-sm btn-danger remove-subtask">×</button>
            </div>
        `);
            });

            $(document).on('click', '.remove-subtask', function() {
                $(this).closest('.subtask-row').remove();
            });

            // Get Task Container by Priority
            function getContainer(priority) {
                return {
                    critical: $('#critical-tasks'),
                    high: $('#high-tasks'),
                    medium: $('#medium-tasks'),
                    low: $('#low-tasks')
                } [priority] || $('#low-tasks');
            }

            // Append Task Card
            function appendTaskCard(task) {
                const container = getContainer(task.priority_level);
                container.find('p.text-center').remove();
                container.append(`
            <div class="card task-card mb-2" data-id="${task.id}" data-priority="${task.priority_level}">
                <div class="card-body p-2 justify-content-between d-flex">
                    <span>${task.title}</span>
                    <span>${new Date(task.created_at).toDateString().slice(4)}</span>
                </div>
            </div>
        `);
            }

            // Create Task
            $('#taskForm').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3
                    },
                    description: {
                        minlength: 5
                    },
                    priority_level: {
                        required: true
                    }
                },
                errorClass: 'text-danger',
                submitHandler: function(form) {
                    const formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        method: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            appendTaskCard(res);
                            $('#taskModal').modal('hide');
                            form.reset();
                            $('#create-subtasks-container').empty();
                            createSubIndex = 0;
                            Toast.fire({
                                icon: 'success',
                                title: 'Task created successfully!'
                            });
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.message ||
                                    'Error creating task'
                            });
                        }
                    });
                }
            });
            $('#saveTask').on('click', function() {
                $('#taskForm').submit();
            });


            // View Task
            $(document).on('click', '.task-card', function() {
                const id = $(this).data('id');

                $.get('/tasks/' + id, function(data) {
                    $('#view-title').text(data.title);
                    $('#view-description').text(data.description || 'No any description');
                    $('#view-priority_level').text(data.priority_level);
                    $('#view-created-at').text(new Date(data.created_at).toDateString().slice(4));
                    $('#view-updated-at').text(new Date(data.updated_at).toDateString().slice(4));

                    const subtasksContainer = $('#view-subtasks').empty();
                    if (data.subtasks && data.subtasks.length) {
                        data.subtasks.forEach(sub => {
                            subtasksContainer.append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${sub.subtask_text}
                            ${sub.is_completed
                                ? '<span class="badge bg-success">Done</span>'
                                : '<span class="badge bg-secondary">Pending</span>'}
                        </li>
                    `);
                        });
                    } else {
                        subtasksContainer.append(
                            '<li class="list-group-item text-muted">No subtasks</li>');
                    }

                    $('#editTaskBtn').data('id', data.id);
                    $('#viewDetailsModal').modal('show');
                }).fail(function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading task details'
                    });
                });
            });

            // Edit Task (Load)
            $(document).on('click', '#editTaskBtn', function() {
                const id = $(this).data('id');

                $.get('/tasks/' + id, function(data) {
                    $('#editForm input[name="id"]').val(data.id);
                    $('#edit-title').val(data.title);
                    $('#edit-description').val(data.description);
                    $('#edit-priority_level').val(data.priority_level);
                    $('#edit-subtasks-container').empty();
                    editSubIndex = 0;

                    (data.subtasks || []).forEach(function(sub) {
                        editSubIndex++;
                        $('#edit-subtasks-container').append(`
                    <div class="subtask-row d-flex align-items-center mb-2">
                        <input type="hidden" name="subtasks[${editSubIndex}][id]" value="${sub.id}">
                        <input type="hidden" name="subtasks[${editSubIndex}][completed]" value="0">
                        <input type="checkbox" class="me-2" name="subtasks[${editSubIndex}][completed]" value="1" ${sub.is_completed ? 'checked' : ''}>
                        <input type="text" class="form-control me-2" name="subtasks[${editSubIndex}][text]" value="${sub.subtask_text}">
                        <button type="button" class="btn btn-sm btn-danger remove-subtask">×</button>
                    </div>
                `);
                    });

                    $('#viewDetailsModal').modal('hide');
                    $('#EditTaskModal').modal('show');

                }).fail(function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading task details'
                    });
                });
            });

            // Update Task
            $('#updateTask').click(function() {
                if (!$('#editForm').valid()) return;

                const id = $('#editForm input[name="id"]').val();
                const formData = new FormData($('#editForm')[0]);


                $.ajax({
                    url: '/tasks/' + id,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('.task-card[data-id="' + id + '"]').remove();
                        appendTaskCard(res);
                        $('#view-title').text(res.title);
                        $('#view-description').text(res.description || 'No any description');
                        $('#view-priority_level').text(res.priority_level);
                        $('#view-created-at').text(new Date(res.created_at).toDateString()
                            .slice(4));
                        $('#view-updated-at').text(new Date(res.updated_at).toDateString()
                            .slice(4));

                        const subtasksContainer = $('#view-subtasks').empty();
                        if (res.subtasks && res.subtasks.length) {
                            res.subtasks.forEach(sub => {
                                subtasksContainer.append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${sub.subtask_text}
                                ${sub.is_completed
                                    ? '<span class="badge bg-success">Done</span>'
                                    : '<span class="badge bg-secondary">Pending</span>'}
                            </li>
                        `);
                            });
                        } else {
                            subtasksContainer.append(
                                '<li class="list-group-item text-muted">No subtasks</li>');
                        }
                        $('#EditTaskModal').modal('hide');
                        $('#viewDetailsModal').modal('show');
                        Toast.fire({
                            icon: 'success',
                            title: 'Task updated successfully!'
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Error updating task'
                        });
                    }
                });
            });

            // Delete Task
            $('#deleteTask').click(function() {
                const id = $('#editForm input[name="id"]').val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This task will be permanently deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/tasks/' + id,
                            method: 'DELETE',
                            success: function() {
                                $('.task-card[data-id="' + id + '"]').remove();
                                $('#EditTaskModal').modal('hide');
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Task deleted successfully!'
                                });
                            },
                            error: function() {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Error deleting task'
                                });
                            }
                        });
                    }
                });
            });

            // Reset Modals
            $('#taskModal').on('hidden.bs.modal', function() {
                $('#taskForm')[0].reset();
                $('#create-subtasks-container').empty();
                createSubIndex = 0;
            });

            $('#EditTaskModal').on('hidden.bs.modal', function() {
                $('#editForm')[0].reset();
                $('#edit-subtasks-container').empty();
                editSubIndex = 0;
            });
        });
    </script>
@endpush
