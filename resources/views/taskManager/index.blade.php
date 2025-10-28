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
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow border-0 rounded-3">

                <!-- Header -->
                <div class="modal-header bg-light border-bottom-0 py-3">
                    <h5 class="modal-title fw-bold text-dark">Task Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 pb-3">

                    <!-- Title & Priority -->
                    <div class="mb-3 pb-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label fw-semibold text-muted mb-0">Title</label>
                            <span id="view-priority_level" class="badge bg-secondary text-capitalize"></span>
                        </div>
                        <p id="view-title" class="fw-bold mb-1 mt-1 fs-6 text-dark"></p>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Description</label>
                        <p id="view-description" class="form-control-plaintext mb-0 ps-1 text-dark"></p>
                    </div>

                    <!-- Subtask Tabs -->
                    <ul class="nav nav-tabs small mb-3" id="subtaskTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-1 px-3" id="pending-tab" data-bs-toggle="tab"
                                data-bs-target="#pending-subtasks" type="button" role="tab">🕓 Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-1 px-3" id="completed-tab" data-bs-toggle="tab"
                                data-bs-target="#completed-subtasks" type="button" role="tab">✅ Completed</button>
                        </li>
                    </ul>

                    <div class="tab-content border rounded-2" id="subtaskTabsContent" style="min-height: 120px;">
                        <div class="tab-pane fade show active" id="pending-subtasks" role="tabpanel">
                            <ul id="view-pending-subtasks" class="list-group list-group-flush small"></ul>
                        </div>
                        <div class="tab-pane fade" id="completed-subtasks" role="tabpanel">
                            <ul id="view-completed-subtasks" class="list-group list-group-flush small"></ul>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="mt-3 border-top pt-2 small text-muted">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="fw-semibold text-muted"></span>
                            <div class="text-end">
                                <div>Created: <span id="view-created-at" class="fw-semibold text-dark"></span></div>
                                <div>Updated: <span id="view-updated-at" class="fw-semibold text-dark"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 bg-white d-flex justify-content-end py-2 pe-3">
                    <button class="btn btn-sm btn-outline-secondary me-2 px-3" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary px-3" id="editTaskBtn">
                        <i class=""></i> Edit
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

            // VIEW TASK (with Pending/Completed Tabs)
            $(document).on('click', '.task-card', function() {
                const id = $(this).data('id');
                $.get('/tasks/' + id, function(data) {
                    $('#view-title').text(data.title);
                    $('#view-description').text(data.description || 'No description');
                    $('#view-priority_level').removeClass().addClass('badge text-capitalize')
                        .addClass(
                            data.priority_level === 'critical' ? 'bg-danger' :
                            data.priority_level === 'high' ? 'bg-high text-dark' :
                            data.priority_level === 'medium' ? 'bg-warning text-dark' : 'bg-success'
                        ).text(data.priority_level);
                    $('#view-created-at').text(new Date(data.created_at).toDateString().slice(4));
                    $('#view-updated-at').text(new Date(data.updated_at).toDateString().slice(4));

                    const pendingList = $('#view-pending-subtasks').empty();
                    const completedList = $('#view-completed-subtasks').empty();
                    if (data.subtasks && data.subtasks.length > 0) {
                        let hasPending = false,
                            hasCompleted = false;
                        data.subtasks.forEach(sub => {
                            const item =
                                `<li class="list-group-item d-flex justify-content-between align-items-center">${sub.subtask_text}${sub.is_completed?
                                    '<span class="badge bg-success">Done</span>':'<span class="badge bg-warning text-dark">Pending</span>'}</li>`;
                            if (sub.is_completed) {
                                completedList.append(item);
                                hasCompleted = true;
                            } else {
                                pendingList.append(item);
                                hasPending = true;
                            }
                        });
                        if (!hasPending) pendingList.append(
                            '<li class="list-group-item text-muted">No pending subtasks</li>');
                        if (!hasCompleted) completedList.append(
                            '<li class="list-group-item text-muted">No completed subtasks</li>');
                    } else {
                        pendingList.append(
                            '<li class="list-group-item text-center text-muted">No subtasks available</li>'
                        );
                        completedList.append(
                            '<li class="list-group-item text-center text-muted">No subtasks available</li>'
                        );
                    }

                    $('#editTaskBtn').data('id', data.id);
                    $('#viewDetailsModal').modal('show');
                }).fail(() => Toast.fire({
                    icon: 'error',
                    title: 'Error loading task details'
                }));
            });

            // EDIT TASK (Load)
            $(document).on('click', '#editTaskBtn', function() {
                const id = $(this).data('id');
                $.get('/tasks/' + id, function(data) {
                    $('#editForm input[name="id"]').val(data.id);
                    $('#edit-title').val(data.title);
                    $('#edit-description').val(data.description);
                    $('#edit-priority_level').val(data.priority_level);
                    $('#edit-subtasks-container').empty();
                    editSubIndex = 0;
                    (data.subtasks || []).forEach(sub => {
                        editSubIndex++;
                        $('#edit-subtasks-container').append(`
                    <div class="subtask-row d-flex align-items-center mb-2">
                        <input type="hidden" name="subtasks[${editSubIndex}][id]" value="${sub.id}">
                        <input type="hidden" name="subtasks[${editSubIndex}][completed]" value="0">
                        <input type="checkbox" class="me-2" name="subtasks[${editSubIndex}][completed]" value="1" ${sub.is_completed?'checked':''}>
                        <input type="text" class="form-control me-2" name="subtasks[${editSubIndex}][text]" value="${sub.subtask_text}">
                        <button type="button" class="btn btn-sm btn-danger remove-subtask">×</button>
                    </div>`);
                    });
                    $('#viewDetailsModal').modal('hide');
                    $('#EditTaskModal').modal('show');
                }).fail(() => Toast.fire({
                    icon: 'error',
                    title: 'Error loading task details'
                }));
            });

            // UPDATE TASK
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
                    success: function(data) {
                        $('.task-card[data-id="' + id + '"]').remove();
                        appendTaskCard(data);
                        $('#view-title').text(data.title);
                        $('#view-description').text(data.description || 'No description');
                        $('#view-priority_level').removeClass().addClass(
                            'badge text-capitalize').addClass(
                            data.priority_level === 'critical' ? 'bg-danger' :
                            data.priority_level === 'high' ? 'bg-high text-dark' :
                            data.priority_level === 'medium' ? 'bg-warning text-dark' :
                            'bg-success'
                        ).text(data.priority_level);
                        $('#view-created-at').text(new Date(data.created_at).toDateString()
                            .slice(4));
                        $('#view-updated-at').text(new Date(data.updated_at).toDateString()
                            .slice(4));

                        const pendingList = $('#view-pending-subtasks').empty();
                        const completedList = $('#view-completed-subtasks').empty();
                        if (data.subtasks && data.subtasks.length > 0) {
                            let hasPending = false,
                                hasCompleted = false;
                            data.subtasks.forEach(sub => {
                                const item =
                                    `<li class="list-group-item d-flex justify-content-between align-items-center">${sub.subtask_text}${sub.is_completed?
                                        '<span class="badge bg-success">Done</span>':'<span class="badge bg-warning text-dark">Pending</span>'}</li>`;
                                if (sub.is_completed) {
                                    completedList.append(item);
                                    hasCompleted = true;
                                } else {
                                    pendingList.append(item);
                                    hasPending = true;
                                }
                            });
                            if (!hasPending) pendingList.append(
                                '<li class="list-group-item text-muted">No pending subtasks</li>'
                            );
                            if (!hasCompleted) completedList.append(
                                '<li class="list-group-item text-muted">No completed subtasks</li>'
                            );
                        } else {
                            pendingList.append(
                                '<li class="list-group-item text-center text-muted">No subtasks available</li>'
                            );
                            completedList.append(
                                '<li class="list-group-item text-center text-muted">No subtasks available</li>'
                            );
                        }

                        $('#EditTaskModal').modal('hide');
                        $('#viewDetailsModal').modal('show');
                        $('#editForm')[0].reset();
                        $('#edit-subtasks-container').empty();
                        editSubIndex = 0;
                        Toast.fire({
                            icon: 'success',
                            title: 'Task updated successfully!'
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Error updating task'
                        })
                    }
                });
            });

            // DELETE TASK
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
        });
    </script>
@endpush
