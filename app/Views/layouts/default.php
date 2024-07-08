<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection("title") ?> </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?= base_url('css/styles.css'); ?>">
    <meta name="csrf-token" content="<?= csrf_token() ?>"> <!-- Add this line -->

</head>
<body>
<header class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= base_url('/') ?>">ServiceIT+</a>
    <button class="navbar-toggler" type="button" id="menu-toggle">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/dashboard') ?>">Dashboard</a>
            </li>
            <?php  if (auth()->loggedIn()): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="timeTrackingDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Time Tracking
                </a>
                <div class="dropdown-menu" aria-labelledby="timeTrackingDropdown">
                    <a class="dropdown-item" href="<?= base_url('/my-times') ?>">My Times</a>
                    <a class="dropdown-item" href="<?= base_url('/weekly-hours') ?>">Weekly Hours</a>
                    <a class="dropdown-item" href="<?= base_url('/calendar') ?>">Calendar</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/reporting') ?>">Reporting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/tasks') ?>">Tasks</a>
            </li>
            <?php if (auth()->user()->inGroup("admin")): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/users') ?>">Users</a>
            </li>
            <?php endif; ?>
        </ul>



        <ul class="navbar-nav ml-auto">
     
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= auth()->user()->username; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url('/profile/edit') ?>">Edit Profile</a>
                        <a class="dropdown-item" href="<?= base_url('/logout') ?>">Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/login') ?>">Login</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <div class="btn-group" role="group" aria-label="Time Tracking">
                    <button id="time-toggle-btn" type="button" class="btn btn-primary">
                        <i id="time-toggle-icon" class="fas fa-play"></i> Start
                    </button>
                    <span id="timer" class="ml-3 nav-link">00:00:00</span>
                </div>
            </li>
        </ul>
    </div>
</header>

<?php if (session()->has("message")): ?>
    
    <p><?= session("message") ?></p>

<?php endif; ?>

<?php if (session()->has("error")): ?>

    <p><?= session("error") ?></p>

<?php endif; ?>

<?= $this->renderSection("content") ?>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">&copy; <?= date('Y') ?> My Dashboard</span>
    </div>
</footer>
<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="task">Task:</label>
          <input type="text" class="form-control" id="task">
        </div>
        <div class="form-group">
          <label for="project-name">Project Name:</label>
          <select class="form-control" id="project-name">
            <option value="project1">Project 1</option>
            <option value="project2">Project 2</option>
            <option value="project3">Project 3</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select class="form-control" id="status">
            <option value="in-progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
          </select>
        </div>
        <div class="form-group">
          <label for="product">Product:</label>
          <select class="form-control" id="product">
            <option value="product1">Product 1</option>
            <option value="product2">Product 2</option>
            <option value="product3">Product 3</option>
          </select>
        </div>
        <div class="form-group">
          <label for="task-type">Task Type:</label>
          <select class="form-control" id="task-type">
            <option value="initiative">Initiative</option>
            <option value="project">Project</option>
            <option value="developmental">Developmental</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="continue-btn" class="btn btn-primary">Continue</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>
</body>
</html>