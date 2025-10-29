<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 510px;">
        <div class="modal-content border-0 rounded-3 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title">Add Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm" autocomplete="off" action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="e.g., Task name"
                                maxlength="120" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Priority Level</label>
                            <select class="form-select" name="priority_level" required>
                                <option value="" selected>Select Priority</option>
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Add a short description (optional)"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subtasks</label>
                            <div id="create-subtasks-container" class="list-group border rounded-2 p-2"
                                aria-live="polite"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addCreateSubtask">
                                <i class="fa fa-plus"></i> Add Subtask
                            </button>
                            <small class="text-muted d-block mt-1">Add as many as needed</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveTask">
                    <span class="spinner-border spinner-border-sm d-none me-1"></span>
                    <i class="fa fa-save"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
