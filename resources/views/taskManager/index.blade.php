@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4" name="header">
            <h2 class=" text-muted fw-semibold fs-4 text-dark mb-0">Task Manager</h2>
            <button class="btn btn-primary fw-semibold shadow-lg" data-bs-toggle="modal" data-bs-target="#taskModal"> + Add
                Task</button>
        </div>

        <div class="row mt-5 ">
            <!-- Critical Tasks -->
            <div class="col-md-3">
                <div class="card  text-black  mb-4 border border-danger">
                    <div class="card-header fw-semibold bg-danger">Critical</div>
                    <div class="card-body" id="critical-tasks">
                        @forelse($tasks['critical'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <small class="text-muted">{{ $task->created_at->format('M d Y') }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-light-49">No critical tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- High Tasks -->
            <div class="col-md-3">
                <div class="card  text-black mb-4 border border-high">
                    <div class="card-header fw-semibold bg-high">High</div>
                    <div class="card-body" id="high-tasks">
                        @forelse($tasks['high'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <small class="text-muted">{{ $task->created_at->format('M d Y') }}</small>
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
                <div class="card  text-dark  mb-4 border border-warning">
                    <div class="card-header fw-semibold bg-warning">Medium</div>
                    <div class="card-body" id="medium-tasks">
                        @forelse($tasks['medium'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <small class="text-muted">{{ $task->created_at->format('M d Y') }}</small>
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
                <div class="card  text-black mb-4 border border-success">
                    <div class="card-header  fw-semibold bg-success">Low</div>
                    <div class="card-body" id="low-tasks">
                        @forelse($tasks['low'] as $task)
                            <div class="card task-card mb-2" data-id="{{ $task->id }}"
                                data-priority="{{ $task->priority_level }}">
                                <div class="card-body p-2 justify-content-between d-flex">
                                    <span>{{ $task->title }}</span>
                                    <small class="text-muted">{{ $task->created_at->format('M d Y') }}</small>

                                </div>
                            </div>
                        @empty
                            <p class="text-center text-light-49">No low priority tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Task Modal -->
    @include('taskManager.modalPartials.addmodal')

    <!-- View Task Details Modal -->
    @include('taskManager.modalPartials.viewModal')

    <!-- Edit Task Modal -->
    @include('taskManager.modalPartials.editModal')
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
                    <input type="text" class="form-control me-2"    name="subtasks[${editSubIndex}][text]" placeholder="Enter subtask">
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
                        <small class="text-muted">${new Date(task.created_at).toDateString().slice(4)}</small>
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
                    },
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters"
                    },
                    description: {
                        minlength: "Description must be at least 5 characters"
                    },
                    priority_level: {
                        required: "Please select a priority"
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
                            const item = `
                                    <li class="list-group-item d-flex justify-content-between align-items-center ">
                                        <div class="d-flex align-items-center justify-content-between subtask ">
                                            <div>
                                                <input class="form-check-input me-2 view-subtask-checkbox"
                                                    type="checkbox"
                                                    data-id="${sub.id}"
                                                    ${sub.is_completed ? 'checked disabled' : ''}>
                                                <span>${sub.subtask_text}</span>
                                            </div>
                                              ${sub.is_completed ? `<small class="text-muted ms-3 ">Completed: ${new Date(sub.updated_at).toLocaleDateString()}</small>` : ''}
                                        </div>

                                        <span class="badge ${sub.is_completed ? 'bg-success' : 'bg-warning text-dark'}">
                                            ${sub.is_completed ? 'Done'  : 'Pending'}
                                        </span>
                                    </li>`;
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

            // Subtask Completion Toggle
            $(document).on('change', '.view-subtask-checkbox', function() {
                const cbox = $(this),
                    id = cbox.data('id'),
                    completed = cbox.is(':checked') ? 1 : 0;

                $.ajax({
                    url: '/subtasks/' + id,
                    method: 'PATCH',
                    data: {
                        is_completed: completed
                    },
                    success: function() {
                        const li = cbox.closest('li');
                        const pendingList = $('#view-pending-subtasks');
                        const completedList = $('#view-completed-subtasks');

                        // Move item visually
                        if (completed) {
                            li.find('span.badge')
                                .removeClass('bg-warning text-dark')
                                .addClass('bg-success')
                                .text('Done')
                            completedList.append(li);
                            li.find('div.subtask')
                                .append(` <small class="text-muted ms-3 ">Completed: ${new Date().toLocaleDateString()}</small>`);
                            completedList.append(li);
                        } else {
                            li.find('span.badge')
                                .removeClass('bg-success')
                                .addClass('bg-warning text-dark')
                                .text('Pending');
                            pendingList.append(li);
                        }

                        //  Remove “No pending/completed subtasks”
                        if (pendingList.children('li').length === 0) { //?
                            pendingList.append(
                                '<li class="list-group-item text-muted">No pending subtasks</li>'
                            );
                        } else {
                            pendingList.find('.text-muted:contains("No pending subtasks")')
                                .remove();
                        }

                        if (completedList.children('li').length === 0) {
                            completedList.append(
                                '<li class="list-group-item text-muted">No completed subtasks</li>'
                            );
                        } else {
                            completedList.find('.text-muted:contains("No completed subtasks")')
                                .remove();
                        }
                        if (completed) cbox.prop('disabled', true);

                        Toast.fire({
                            icon: 'success',
                            title: 'Subtask updated!'
                        });
                    },
                    error: function() {
                        cbox.prop('checked', !completed);
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update subtask'
                        });
                    }
                });
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
                            <input type="text" class="form-control me-2"    name="subtasks[${editSubIndex}][text]" value="${sub.subtask_text}">
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
            $('#editForm').validate({
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
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters"
                    },
                    description: {
                        minlength: "Description must be at least 5 characters"
                    },
                    priority_level: {
                        required: "Please select a priority"
                    }
                },
                errorClass: 'text-danger',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    const id = $('#editForm input[name="id"]').val();
                    const formData = new FormData(form);

                    $.ajax({
                        url: '/tasks/' + id,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            // Replace old card
                            $('.task-card[data-id="' + id + '"]').remove();
                            appendTaskCard(data);

                            // Update details modal
                            $('#view-title').text(data.title);
                            $('#view-description').text(data.description ||
                                'No description');
                            $('#view-priority_level')
                                .removeClass()
                                .addClass('badge text-capitalize')
                                .addClass(
                                    data.priority_level === 'critical' ?
                                    'bg-danger' :
                                    data.priority_level === 'high' ?
                                    'bg-high text-dark' :
                                    data.priority_level === 'medium' ?
                                    'bg-warning text-dark' :
                                    'bg-success'
                                )
                                .text(data.priority_level);

                            $('#view-created-at').text(new Date(data.created_at)
                                .toDateString().slice(4));
                            $('#view-updated-at').text(new Date(data.updated_at)
                                .toDateString().slice(4));

                            // Update subtasks
                            const pendingList = $('#view-pending-subtasks').empty();
                            const completedList = $('#view-completed-subtasks').empty();

                            if (data.subtasks && data.subtasks.length > 0) {
                                let hasPending = false,
                                    hasCompleted = false;
                                data.subtasks.forEach(sub => {
                                    const item = `
                                            <li class="list-group-item d-flex justify-content-between align-items-center ">
                                                <div class="d-flex align-items-center justify-content-between subtask ">
                                                    <div>
                                                        <input class="form-check-input me-2 view-subtask-checkbox"
                                                            type="checkbox"
                                                            data-id="${sub.id}"
                                                            ${sub.is_completed ? 'checked disabled' : ''}>
                                                        <span>${sub.subtask_text}</span>
                                                    </div>
                                                    ${sub.is_completed ? `<small class="text-muted ms-3 ">Completed: ${new Date(sub.updated_at).toLocaleDateString()}</small>` : ''}
                                                </div>

                                                <span class="badge ${sub.is_completed ? 'bg-success' : 'bg-warning text-dark'}">
                                                    ${sub.is_completed ? 'Done'  : 'Pending'}
                                                </span>
                                            </li>`;
                                    if (sub.is_completed) {
                                        completedList.append(item);
                                        hasCompleted = true;
                                    } else {
                                        pendingList.append(item);
                                        hasPending = true;
                                    }
                                });

                                if (!hasPending)
                                    pendingList.append(
                                        '<li class="list-group-item text-muted">No pending subtasks</li>'
                                    );
                                if (!hasCompleted)
                                    completedList.append(
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

                            // Reset modal & form
                            $('#EditTaskModal').modal('hide');
                            $('#viewDetailsModal').modal('show');
                            form.reset();
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
                                title: xhr.responseJSON?.message ||
                                    'Error updating task'
                            });
                        }
                    });
                }
            });
            //  UPDATE BUTTON CLICK
            $('#updateTask').on('click', function() {
                $('#editForm').submit();
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
