<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?> My Times <?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="container mt-5">
    <h2>My Times</h2>
    <i class="fas fa-cogs" style="cursor: pointer;" data-toggle="modal" data-target="#columnSettingsModal"></i> 

    <table class="table table-striped"
           id="time-log-table"
           data-pagination="true"
           data-page-list="[5, 10, 20, 50]"
           data-search="true">
        <thead>
            <tr>
                <th class="col-date" scope="col" data-sortable="true">Date</th>
                <th class="col-start-time" scope="col" data-sortable="true">Start Time</th>
                <th class="col-end-time" scope="col" data-sortable="true">End Time</th>
                <th class="col-duration" scope="col" data-sortable="true">Duration</th>
                <th class="col-task" scope="col" data-sortable="true">Task</th>
                <th class="col-proj" scope="col" data-sortable="true">Project Name</th>
                <th class="col-act" scope="col" data-sortable="true">Activity</th>
                <th class="col-status" scope="col" data-sortable="true">Status</th>
                <th class="col-product" scope="col" data-sortable="true">Product</th>
              
                <th class="col-action" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="time-log">
        <?php foreach ($timeLogs as $log): ?>
            <tr>
                <td class="col-date"><?= date('Y-m-d', strtotime($log['start_time'])) ?></td>
                <td class="col-start-time"><?= date('H:i:s', strtotime($log['start_time'])) ?></td>
                <td class="col-end-time"><?= date('H:i:s', strtotime($log['end_time'])) ?></td>
                <td class="col-duration"><?= $log['duration'] ?> minutes</td>
                <td class="col-task"><?= $log['task'] ?? 'N/A' ?></td>
                <td class="col-proj"><?= $log['project_name'] ?? 'N/A' ?></td>
                <td class="col-act"><?= $log['task_type']  ?></td>
                <td class="col-status"><?= $log['status'] ?? 'N/A' ?></td>
                <td class="col-product"><?= $log['product'] ?? 'N/A' ?></td>
                <td class="col-action">
                    <i class="fas fa-edit edit-time-log" style="cursor: pointer;" data-id="<?= $log['id'] ?>"></i>
                    <i class="fas fa-trash-alt delete-time-log ml-2" style="cursor: pointer;" data-id="<?= $log['id'] ?>"></i>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Time Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTimeLogForm">
                <div class="modal-body">
                    <input type="hidden" id="edit-log-id">
                    <!-- <div class="form-group">
                        <label for="edit-start-time">Start Time:</label>
                        <input type="datetime-local" class="form-control" id="edit-start-time" name="edit-start-time" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-end-time">End Time:</label>
                        <input type="datetime-local" class="form-control" id="edit-end-time" name="edit-end-time" required>
                    </div> -->
                    <div class="form-group">
                        <label for="edit-task-type">Task Type:</label>
                        <select class="form-control" id="edit-task-type" name="edit-task-type">
                            <option value="initiative">Initiative</option>
                            <option value="project">Project</option>
                            <option value="developmental">Developmental</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-task">Task:</label>
                        <input type="text" class="form-control" id="edit-task" name="edit-task" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-project">Project Name:</label>
                        <select class="form-control" id="edit-project" name="edit-project">
                            <!-- Populate options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Status:</label>
                        <select class="form-control" id="edit-status" name="edit-status">
                            <!-- Populate options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-product">Product:</label>
                        <select class="form-control" id="edit-product" name="edit-product">
                            <!-- Populate options dynamically if needed -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveEditBtn" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Column Settings -->
<div class="modal fade" id="columnSettingsModal" tabindex="-1" aria-labelledby="columnSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="columnSettingsModalLabel">Customize Columns</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnSettingsForm">
                    <div class="form-group">
                        <label>Select columns to display:</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxDate" checked>
                            <label class="custom-control-label" for="checkboxDate">Date</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxStartTime" checked>
                            <label class="custom-control-label" for="checkboxStartTime">Start Time</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxEndTime" checked>
                            <label class="custom-control-label" for="checkboxEndTime">End Time</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxDuration" checked>
                            <label class="custom-control-label" for="checkboxDuration">Duration</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxTask" checked>
                            <label class="custom-control-label" for="checkboxTask">Task</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxProj" checked>
                            <label class="custom-control-label" for="checkboxProj">Project Name</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxAct" checked>
                            <label class="custom-control-label" for="checkboxAct">Activity</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxStatus" checked>
                            <label class="custom-control-label" for="checkboxStatus">Status</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxProduct" checked>
                            <label class="custom-control-label" for="checkboxProduct">Product</label>
                        </div>
                    </div>
                    <button type="button" id="applyColumnsBtn" class="btn btn-primary">Apply Changes</button>
                </form>
            </div>
        </div>
    </div>
</div> 
<?= $this->endSection() ?>
