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
