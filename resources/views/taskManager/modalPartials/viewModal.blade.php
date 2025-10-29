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
                            data-bs-target="#pending-subtasks" type="button" role="tab"><i
                                class="fa fa-hourglass-start"></i> Pending</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-1 px-3" id="completed-tab" data-bs-toggle="tab"
                            data-bs-target="#completed-subtasks" type="button" role="tab"><i
                                class="fa fa-check"></i> Completed</button>
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
                    <i class="fa fa-pencil-alt"></i> Edit
                </button>
            </div>

        </div>
    </div>
</div>
