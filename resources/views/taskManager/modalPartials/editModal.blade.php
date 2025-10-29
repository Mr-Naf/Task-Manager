<div class="modal fade" id="EditTaskModal" tabindex="-1" aria-labelledby="editTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-body-tertiary">
                <h5 class="modal-title d-flex align-items-center gap-2" id="editTaskLabel">
                    <i class="bi bi-clipboard-check"></i>
                    Task Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editForm" class="needs-validation" novalidate autocomplete="off" method="POST">
                    @csrf
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label for="edit-title" class="form-label fw-semibold">Title</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit-title" name="title"
                                placeholder="Enter task title" required>
                            <div class="invalid-feedback">Title is required.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="4"
                            placeholder="Add a short description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-priority_level" class="form-label fw-semibold">Priority</label>
                        <div class="input-group w-100 shadow-sm">
                            <select class="form-select" id="edit-priority_level" name="priority_level">
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtasks</label>
                        <div id="edit-subtasks-container" class="list-group border rounded-3 p-2 bg-body-tertiary">
                            <div class="text-muted small text-center py-2">No subtasks yet</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addEditSubtask">
                            <i class="fa fa-plus me-1"></i> Add Subtask
                        </button>
                    </div>

                </form>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-danger" id="deleteTask" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Delete this task">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                    <i class="fa fa-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-primary" id="updateTask">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                    <i class="fa fa-save"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
