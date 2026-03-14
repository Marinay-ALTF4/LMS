<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

  <!-- Header -->
  <?php include('app/Views/templates/header.php'); ?>

  <?php
    $currentYear = (int) date('Y');
    $teacherYearOptions = [
      $currentYear . '-' . ($currentYear + 1),
      ($currentYear + 1) . '-' . ($currentYear + 2),
      ($currentYear + 2) . '-' . ($currentYear + 3),
    ];
    $teacherTimeOptions = [
      'MWF 8:00-9:00 AM',
      'MWF 9:00-10:00 AM',
      'MWF 10:00-11:00 AM',
      'MWF 1:00-2:00 PM',
      'TTh 9:00-10:30 AM',
      'TTh 1:00-2:30 PM',
      'TTh 3:00-4:30 PM',
      'Sat 8:00-11:00 AM',
    ];
  ?>

  <div class="container my-5">
    <div class="card shadow-sm">
      <div class="card-body">

        <?php $role = $role ?? session()->get('role'); ?>

        <!-- Welcome -->
        <h3 class="mb-3"><i class="bi bi-person-circle me-2"></i>Welcome, <?= esc(session()->get('name') ?? 'User') ?>!</h3>
        <p class="text-muted <?= strtolower((string) $role) === 'student' ? 'mb-1' : 'mb-4' ?>">Role: <strong><?= esc($role ?? 'User') ?></strong></p>
        <?php if (strtolower((string) $role) === 'student'): ?>
          <p class="text-muted mb-4">Course: <strong><?= esc(session()->get('course_name') ?? ($data['profile']['course_name'] ?? 'BSIT')) ?></strong></p>
        <?php endif; ?>
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        
        <hr>

        <!--  ADMIN DASHBOARD  -->
        <?php if ($role === 'admin'): ?>
          <?php
            $allUsers = $data['users'] ?? [];
            $activeUsers = array_filter($allUsers, static fn($u) => empty($u['deleted_at']));
            $adminCount = count(array_filter($activeUsers, static fn($u) => (($u['role'] ?? '') === 'admin')));
            $teacherCount = count(array_filter($activeUsers, static fn($u) => (($u['role'] ?? '') === 'teacher')));
            $studentCount = count(array_filter($activeUsers, static fn($u) => (($u['role'] ?? '') === 'student')));
          ?>

          <section class="admin-dashboard">
            <div class="admin-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm text-white">
              <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                  <span class="badge text-bg-light text-primary mb-3">Admin Center</span>
                  <h4 class="mb-2 fw-bold">Admin Dashboard</h4>
                  <p class="mb-0">Manage users, oversee access, and keep the enrollment system organized across roles.</p>
                </div>
                <div class="col-lg-4">
                  <div class="admin-mini-card rounded-3 p-3">
                    <small class="text-uppercase">Total Users</small>
                    <div class="fs-3 fw-bold"><?= isset($data['usersCount']) ? (int)$data['usersCount'] : 0 ?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <div class="summary-card rounded-4 p-3 shadow-sm h-100">
                  <div class="text-muted small">Active Admins</div>
                  <div class="h4 mb-0 text-primary"><?= $adminCount ?></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="summary-card rounded-4 p-3 shadow-sm h-100">
                  <div class="text-muted small">Active Teachers</div>
                  <div class="h4 mb-0 text-primary"><?= $teacherCount ?></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="summary-card rounded-4 p-3 shadow-sm h-100">
                  <div class="text-muted small">Active Students</div>
                  <div class="h4 mb-0 text-primary"><?= $studentCount ?></div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
              <h5 class="mb-0">User Management</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus me-1"></i> Add New User
              </button>
            </div>

            <div class="user-management-panel rounded-4 p-3 p-lg-4 mb-3">

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('admin/user/add') ?>" method="post" id="addUserForm">
        <?= csrf_field() ?>

        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   pattern="[A-Za-z0-9@\.\'\-_ ]{5,}" 
                   title="At least 5 characters. Allowed: letters, numbers, spaces, @ . ' - _"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
                 <small class="form-text text-muted">Use at least 5 characters. Allowed: letters, numbers, spaces, and @ . ' - _</small>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback" id="emailError"></div>
            <small class="form-text text-muted">Must be a valid email address and must be unique.</small>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="admin">Admin</option>
              <option value="teacher">Teacher</option>
              <option value="student">Student</option>
            </select>
            <div class="invalid-feedback" id="roleError"></div>
          </div>

          <div class="mb-3 d-none" id="courseGroup">
            <label for="course_name" class="form-label">Course</label>
            <select class="form-select" id="course_name" name="course_name">
              <option value="">Select Course</option>
              <option value="BSIT">BSIT</option>
              <option value="BSCS">BSCS</option>
            </select>
            <div class="invalid-feedback" id="courseError"></div>
            <small class="form-text text-muted">Required only when role is Student.</small>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" minlength="6" required>
            <div class="invalid-feedback" id="passwordError"></div>
            <small class="form-text text-muted">Password must be at least 6 characters long.</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- User List -->
<?php if (!empty($data['users'])): ?>
  <?php $currentUserId = (int)(session()->get('userID') ?? 0); ?>
  <div class="table-responsive mt-3">
    <table class="table table-striped table-hover table-bordered align-middle admin-table bg-white">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['users'] as $user): ?>
          <?php
            $isDeleted = !empty($user['deleted_at']);
            $isCurrent = ((int)$user['id'] === $currentUserId);
          ?>
          <tr class="<?= $isDeleted ? 'table-secondary' : '' ?>">
            <td><?= (int)$user['id'] ?></td>
            <td>
              <?= esc($user['name']) ?>
              <?php if ($isCurrent): ?>
              <?php endif; ?>
            </td>
            <td class="text-break"><?= esc($user['email']) ?></td>
            <td>
              <?= esc(ucfirst($user['role'])) ?>
              <?php if ($isDeleted): ?>
                <span class="badge bg-secondary ms-1">Deleted</span>
              <?php endif; ?>
            </td>
            <td class="d-flex flex-wrap gap-2">
              <?php if (! $isDeleted): ?>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                  <i class="bi bi-pencil"></i> Edit
                </button>

                <?php if (! $isCurrent): ?>
                  <form action="<?= base_url('admin/user/delete/' . $user['id']) ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </form>
                <?php else: ?>
                  <span class="badge bg-light text-dark border">Current user</span>
                <?php endif; ?>
              <?php else: ?>
                <form action="<?= base_url('admin/user/restore/' . $user['id']) ?>" method="post" class="d-inline">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-success">
                    <i class="bi bi-arrow-counterclockwise"></i> Restore
                  </button>
                </form>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Edit User Modal -->
          <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="<?= base_url('admin/user/edit/' . $user['id']) ?>" method="post">
                  <?= csrf_field() ?>

                  <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel<?= $user['id'] ?>">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="name<?= $user['id'] ?>" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="name<?= $user['id'] ?>" name="name" value="<?= esc($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="email<?= $user['id'] ?>" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email<?= $user['id'] ?>" name="email" value="<?= esc($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="role<?= $user['id'] ?>" class="form-label">Role</label>
                      <select class="form-select" id="role<?= $user['id'] ?>" name="role" required <?= $isCurrent ? 'disabled' : '' ?>>
                        <option value="">Select Role</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                        <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                      </select>
                      <?php if ($isCurrent): ?>
                        <input type="hidden" name="role" value="<?= esc($user['role']) ?>">
                        <small class="text-muted">You cannot change your own role.</small>
                      <?php endif; ?>
                    </div>

                    <div class="mb-3">
                      <label for="password<?= $user['id'] ?>" class="form-label">New Password (optional)</label>
                      <input type="password" class="form-control" id="password<?= $user['id'] ?>" name="password" minlength="6" placeholder="Leave blank to keep current password">
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="alert alert-secondary">No users found.</div>
<?php endif; ?>
            </div>
          </section>

          
          
        <!--  TEACHER DASHBOARD  -->
        <?php elseif ($role === 'teacher'): ?>
          <section class="teacher-dashboard">
            <div class="teacher-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm text-white">
              <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                  <span class="badge text-bg-light text-primary mb-3">Teacher Workspace</span>
                  <h4 class="mb-2 fw-bold"><i class="bi bi-journal-text me-2"></i>Teacher Dashboard</h4>
                  <p class="mb-0">Manage enrollments, update courses, and monitor class materials from one place.</p>
                </div>
                <div class="col-lg-4">
                  <div class="teacher-mini-card rounded-3 p-3">
                    <small class="text-uppercase">Assigned Courses</small>
                    <div class="fs-3 fw-bold"><?= isset($data['courses']) && is_array($data['courses']) ? count($data['courses']) : 0 ?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="alert teacher-note d-flex align-items-center gap-2" role="alert">
              <i class="bi bi-info-circle"></i>
              <div>Open a course below to approve enrollment requests, manage assignments, and upload learning materials.</div>
            </div>

            <h4 class="card-title mb-3">My Courses</h4>

            <div class="row mb-3">
              <div class="col-md-6">
                <form id="teacherSearchForm" class="d-flex">
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="teacherCourseSearch" class="form-control" placeholder="Search my courses..." name="search_term">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Search</button>
                  </div>
                </form>
              </div>
            </div>

            <?php if (!empty($data['courses'])): ?>
              <?php
                $teacherPendingByCourse = [];
                if (!empty($data['pendingEnrollments']) && is_array($data['pendingEnrollments'])) {
                  foreach ($data['pendingEnrollments'] as $pendingEnrollment) {
                    $pendingCourseId = (int) ($pendingEnrollment['course_id'] ?? 0);
                    if ($pendingCourseId > 0) {
                      $teacherPendingByCourse[$pendingCourseId] = ($teacherPendingByCourse[$pendingCourseId] ?? 0) + 1;
                    }
                  }
                }
              ?>
              <div id="teacherCoursesContainer" class="list-group mb-3 teacher-courses-panel p-2 rounded-4">
                <?php foreach ($data['courses'] as $course): ?>
                  <?php $teacherPendingCount = (int) ($teacherPendingByCourse[(int) ($course['id'] ?? 0)] ?? 0); ?>
                  <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative teacher-course-item" data-course-id="<?= (int) $course['id'] ?>" data-search="<?= esc(strtolower((string) ($course['title'] . ' ' . $course['description'] . ' ' . ($course['semester'] ?? '') . ' ' . ($course['school_year'] ?? '')))) ?>">
                    <?php if ($teacherPendingCount > 0): ?>
                      <span class="teacher-course-notif badge rounded-pill bg-danger" title="Pending enrollment requests">
                        <?= $teacherPendingCount ?>
                      </span>
                    <?php endif; ?>
                    <div>
                      <h5 class="mb-1 teacher-course-title"><?= esc($course['title']); ?></h5>
                      <p class="text-dark mb-1">Course Code: <?= esc($course['description']); ?></p>
                      <small class="text-muted d-block">Teacher: <?= esc(session()->get('name')) ?></small>
                      <small class="text-muted d-block">Semester/Term: <?= esc($course['semester'] ?? 'Not set') ?></small>
                      <small class="text-muted d-block">Time: <?= esc($course['class_time'] ?? 'TBA') ?></small>
                      <small class="text-muted d-block">SY: <?= esc($course['school_year'] ?? 'Set school year') ?></small>
                    </div>
                    <div class="d-flex gap-2 align-items-center ms-auto position-relative" style="z-index: 2;">
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCourseModal<?= $course['id'] ?>">Edit</button>
                    </div>
                    <a href="<?= base_url('teacher/course/' . $course['id']) ?>" class="stretched-link" aria-label="View course details"></a>
                  </div>

                  <div class="modal fade" id="editCourseModal<?= $course['id'] ?>" tabindex="-1" aria-labelledby="editCourseModalLabel<?= $course['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form action="<?= base_url('teacher/course/update/' . $course['id']) ?>" method="post">
                          <?= csrf_field() ?>

                        <div class="modal-header">
                          <h5 class="modal-title" id="editCourseModalLabel<?= $course['id'] ?>">Edit Course</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="title<?= $course['id'] ?>" class="form-label">Course Title</label>
                            <input type="text" class="form-control" id="title<?= $course['id'] ?>" name="title" value="<?= esc($course['title']) ?>" required>
                          </div>

                          <div class="mb-3">
                            <label for="description<?= $course['id'] ?>" class="form-label">Course Description</label>
                            <textarea class="form-control" id="description<?= $course['id'] ?>" name="description" rows="3" required><?= esc($course['description']) ?></textarea>
                          </div>

                          <div class="mb-3">
                            <label for="semester<?= $course['id'] ?>" class="form-label">Semester</label>
                            <select class="form-select" id="semester<?= $course['id'] ?>" name="semester">
                              <option value="">Select Semester</option>
                              <option value="1st Semester" <?= (isset($course['semester']) && strpos((string) $course['semester'], '1st Semester') !== false) ? 'selected' : '' ?>>1st Semester</option>
                              <option value="2nd Semester" <?= (isset($course['semester']) && strpos((string) $course['semester'], '2nd Semester') !== false) ? 'selected' : '' ?>>2nd Semester</option>
                              <option value="Summer" <?= (isset($course['semester']) && strpos((string) $course['semester'], 'Summer') !== false) ? 'selected' : '' ?>>Summer</option>
                            </select>
                          </div>

                          <div class="mb-3">
                            <label for="term<?= $course['id'] ?>" class="form-label">Term</label>
                            <select class="form-select" id="term<?= $course['id'] ?>" name="term">
                              <option value="">Select Term</option>
                              <option value="Term 1" <?= (isset($course['semester']) && strpos((string) $course['semester'], 'Term 1') !== false) ? 'selected' : '' ?>>Term 1</option>
                              <option value="Term 2" <?= (isset($course['semester']) && strpos((string) $course['semester'], 'Term 2') !== false) ? 'selected' : '' ?>>Term 2</option>
                              <option value="Term 3" <?= (isset($course['semester']) && strpos((string) $course['semester'], 'Term 3') !== false) ? 'selected' : '' ?>>Term 3</option>
                            </select>
                          </div>

                          <div class="mb-3">
                            <label for="school_year<?= $course['id'] ?>" class="form-label">School Year</label>
                            <select class="form-select" id="school_year<?= $course['id'] ?>" name="school_year" required>
                              <option value="">Select School Year</option>
                              <?php foreach ($teacherYearOptions as $y): ?>
                                <option value="<?= esc($y) ?>" <?= (isset($course['school_year']) && $course['school_year'] === $y) ? 'selected' : '' ?>><?= esc($y) ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="class_time<?= $course['id'] ?>" class="form-label">Time</label>
                            <input list="teacherTimeOptions" type="text" class="form-control" id="class_time<?= $course['id'] ?>" name="class_time" value="<?= esc($course['class_time'] ?? '') ?>" placeholder="Select or type time">
                          </div>
                        </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <p class="text-muted text-center mt-3">No courses assigned yet.</p>
            <?php endif; ?>



            <?php if (!empty($data['materials'])): ?>
              <div class="mt-4 teacher-materials-panel rounded-4 p-3 p-lg-4">
                <h5><i class="bi bi-folder2-open me-2"></i>Uploaded Materials</h5>
                <table class="table table-bordered table-striped mt-3 align-middle bg-white">
                  <thead class="table-light">
                    <tr><th>#</th><th>File Name</th><th>Action</th></tr></thead>
                  <tbody>
                    <?php foreach ($data['materials'] as $index => $mat): ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($mat['file_name']) ?></td>
                        <td>
                          <a href="<?= site_url('materials/delete/' . $mat['id']) ?>" 
                            class="btn btn-outline-danger btn-sm" 
                            onclick="return confirm('Delete this file?')">
                            <i class="bi bi-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </section>

        <!--  STUDENT DASHBOARD  -->
        <?php else: ?>
          <section class="student-dashboard">
            <div class="student-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm text-white">
              <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                  <span class="badge text-bg-light text-primary mb-3">Student Center</span>
                  <h4 class="mb-2 fw-bold">Student Dashboard</h4>
                  <p class="mb-0">Track your classes, check enrollment updates, and access course files quickly.</p>
                </div>
                <div class="col-lg-4">
                  <div class="student-mini-card rounded-3 p-3">
                    <small class="text-uppercase">Enrolled Courses</small>
                    <div class="fs-3 fw-bold"><?= isset($data['courses']) && is_array($data['courses']) ? count($data['courses']) : 0 ?></div>
                  </div>
                </div>
              </div>
            </div>

            <h5>My Profile</h5>
            <?php if (!empty($data['profile'])): ?>
              <div class="row g-3 mb-4 mt-2 student-profile-grid">
                <div class="col-md-6">
                  <div class="p-3 border rounded bg-white">Name: <strong><?= esc($data['profile']['name']) ?></strong></div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 border rounded bg-white">Email: <strong><?= esc($data['profile']['email']) ?></strong></div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 border rounded bg-white">Course: <strong><?= esc($data['profile']['course_name'] ?? 'N/A') ?></strong></div>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-4">
              <div class="col-md-6">
                  <form id="searchForm" class="d-flex">
                      <div class="input-group">
                          <input type="text" id="searchInput" class="form-control" placeholder="Search courses..." name="search_term">
                          <button class="btn btn-outline-primary" type="submit">
                              <i class="bi bi-search"></i> Search
                          </button>
                      </div>
                  </form>
              </div>
            </div>

            <div id="coursesContainer" class="row">
              <?php if (!empty($data['courses'])): ?>
                  <?php foreach ($data['courses'] as $course): ?>
                      <div class="col-md-4 mb-4">
                        <div class="card course-card h-100 student-course-card">
                          <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($course['title']) ?></h5>
                            <p class="card-text">Course Code: <?= esc($course['description']) ?></p>
                            <small class="text-muted d-block">Semester/Term: <?= esc($course['semester'] ?? 'Not set') ?></small>
                            <div class="mt-auto">
                              <a href="<?= base_url('student/course/' . (int) ($course['course_id'] ?? $course['id'] ?? 0)) ?>" class="btn btn-primary w-100">View Course</a>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  <p class="text-muted">No courses available.</p>
              <?php endif; ?>
            </div>

            <?php if (!empty($data['pendingEnrollments'])): ?>
              <div class="mt-3 student-pending-panel rounded-4 p-3 p-lg-4">
                <h6>Pending Enrollment Requests</h6>
                <div class="list-group">
                  <?php foreach ($data['pendingEnrollments'] as $pending): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <strong><?= esc($pending['title'] ?? 'Course') ?></strong>
                        <div class="text-muted small">Course Code: <?= esc($pending['description'] ?? 'N/A') ?></div>
                        <div class="text-muted small">SY: <?= esc($pending['school_year'] ?? 'N/A') ?></div>
                      </div>
                      <span class="badge bg-warning text-dark">Pending</span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <h5 class="mt-4"><i class="bi bi-file-earmark-arrow-down me-2"></i>Course Materials</h5>

            <?php if (!empty($data['materials']) && !empty($data['courses'])): ?>
              <div class="accordion mt-3 student-materials-panel" id="materialsAccordion">
                <?php foreach ($data['courses'] as $course): ?>
                  <?php
                    $courseMaterials = array_filter($data['materials'], function($mat) use ($course) {
                      return $mat['course_id'] == $course['id'];
                    });
                  ?>

                  <?php if (!empty($courseMaterials)): ?>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading<?= $course['id'] ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $course['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $course['id'] ?>">
                          <?= esc($course['title']); ?>
                        </button>
                      </h2>
                      <div id="collapse<?= $course['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $course['id'] ?>" data-bs-parent="#materialsAccordion">
                        <div class="accordion-body">
                          <table class="table table-bordered table-hover bg-white mt-2">
                            <thead class="table-primary">
                              <tr><th>#</th><th>File Name</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                              <?php $index = 1; foreach ($courseMaterials as $mat): ?>
                                <tr>
                                  <td><?= $index++ ?></td>
                                  <td><?= esc($mat['file_name']) ?></td>
                                  <td>
                                    <a href="<?= site_url('materials/download/' . $mat['id']) ?>" class="btn btn-outline-primary btn-sm">
                                      <i class="bi bi-download"></i> Download
                                    </a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <p class="text-muted mt-3">No materials available yet.</p>
            <?php endif; ?>
          </section>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <datalist id="teacherTimeOptions">
    <?php foreach ($teacherTimeOptions as $t): ?>
      <option value="<?= esc($t) ?>">
    <?php endforeach; ?>
  </datalist>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- LAB 9: SEARCH & FILTERING SCRIPT -->
<script>
$(document).ready(function () {

    // Client-side filtering
    $("#searchInput").on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.course-card').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Teacher courses search/filter: mirrors admin behavior
    (function() {
      const input = document.getElementById('teacherCourseSearch');
      const form = document.getElementById('teacherSearchForm');
      const container = document.getElementById('teacherCoursesContainer');
      if (!input || !container) return;

      const items = Array.from(container.querySelectorAll('.teacher-course-item'));
      const noResults = document.createElement('div');
      noResults.className = 'list-group-item text-muted d-none';
      noResults.textContent = 'No courses found matching your search.';
      container.appendChild(noResults);

      function showAll() {
        items.forEach(item => item.classList.remove('d-none'));
        noResults.classList.add('d-none');
      }

      function filterClient(term) {
        let anyVisible = false;
        items.forEach(item => {
          const text = (item.dataset.search || '').toString();
          const show = text.includes(term);
          item.classList.toggle('d-none', term && !show);
          anyVisible = anyVisible || show;
        });
        noResults.classList.toggle('d-none', anyVisible || term === '');
      }

      input.addEventListener('input', () => {
        const term = input.value.toLowerCase();
        if (term === '') {
          showAll();
          return;
        }
        filterClient(term);
      });

      if (form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          const term = input.value.trim();

          if (term === '') {
            showAll();
            return;
          }

          fetch('<?= base_url("courses/search") ?>?search_term=' + encodeURIComponent(term), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
          })
            .then(resp => resp.ok ? resp.json() : Promise.reject())
            .then(data => {
              const hasResults = Array.isArray(data) && data.length > 0;
              if (!hasResults) {
                items.forEach(item => item.classList.add('d-none'));
                noResults.textContent = 'No courses found matching your search.';
                noResults.classList.remove('d-none');
                return;
              }

              const ids = new Set(data.map(c => String(c.id ?? c.course_id ?? '')));
              let anyVisible = false;

              items.forEach(item => {
                const itemId = String(item.dataset.courseId || '');
                const show = ids.has(itemId);
                item.classList.toggle('d-none', !show);
                anyVisible = anyVisible || show;
              });

              noResults.classList.toggle('d-none', anyVisible);
            })
            .catch(() => {
              items.forEach(item => item.classList.add('d-none'));
              noResults.textContent = 'Search failed. Please try again.';
              noResults.classList.remove('d-none');
            });
        });
      }
    })();

    // Server-side search with AJAX
    $("#searchForm").on('submit', function(e) {
        e.preventDefault();
        var searchTerm = $("#searchInput").val();

        $.get('<?= base_url("courses/search") ?>', { search_term: searchTerm }, function(data) {
          $("#coursesContainer").empty();

            if (data.length > 0) {
                $.each(data, function(index, course) {
                    var courseHtml = `
                        <div class="col-md-4 mb-4">
                            <div class="card course-card">
                                <div class="card-body">
                                    <h5 class="card-title">${course.title}</h5>
                            <p class="card-text">Course Code: ${course.description}</p>
                                    <a href="#" class="btn btn-dark">View Course</a>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#coursesContainer").append(courseHtml);
                });
            } else {
                $("#coursesContainer").html(
                    '<div class="col-12"><div class="alert alert-info">No courses found matching your search.</div></div>'
                );
            }
        });
    });

    // USER MANAGEMENT VALIDATION
    // Real-time name validation - prevent special characters and numbers
    $('#name').on('input', function() {
        var nameInput = $(this);
        var name = nameInput.val().trim();
        var namePattern = /^[A-Za-z][A-Za-z\s\.\'\-]*$/;
        
        if (name === '') {
            nameInput.removeClass('is-valid is-invalid');
            nameInput.siblings('.invalid-feedback').text('');
        } else if (!namePattern.test(name)) {
            nameInput.removeClass('is-valid').addClass('is-invalid');
            nameInput.siblings('.invalid-feedback').text('Name can only contain letters, spaces, periods (.), apostrophes (\'), and hyphens (-). No numbers or special characters allowed.');
        } else {
            nameInput.removeClass('is-invalid').addClass('is-valid');
            nameInput.siblings('.invalid-feedback').text('');
        }
    });

    // Real-time email validation with duplicate check
    var emailCheckTimeout;
    $('#email').on('input', function() {
        var emailInput = $(this);
        var email = emailInput.val().trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        clearTimeout(emailCheckTimeout);
        
        if (email === '') {
            emailInput.removeClass('is-valid is-invalid');
            emailInput.siblings('.invalid-feedback').text('');
        } else if (!emailPattern.test(email)) {
            emailInput.removeClass('is-valid').addClass('is-invalid');
            emailInput.siblings('.invalid-feedback').text('Please enter a valid email address.');
        } else {
            // Format is valid - check for duplicates via AJAX (with debounce)
            emailCheckTimeout = setTimeout(function() {
                emailInput.removeClass('is-valid is-invalid');
                
                // Get CSRF token from form
                var csrfTokenName = '<?= csrf_token() ?>';
                var csrfTokenValue = $('#addUserForm input[name="' + csrfTokenName + '"]').val() || '<?= csrf_hash() ?>';
                
                // Check for duplicate email
                $.ajax({
                    url: '<?= base_url("admin/user/check-email") ?>',
                    method: 'POST',
                    data: {
                        email: email,
                        [csrfTokenName]: csrfTokenValue
                    },
                    success: function(response) {
                    // Update CSRF token with the refreshed value returned by the server
                    if (response.csrfTokenName && response.csrfTokenValue) {
                      csrfTokenValue = response.csrfTokenValue;
                      $('#addUserForm input[name="' + response.csrfTokenName + '"]').val(response.csrfTokenValue);
                    }

                        if (response.exists) {
                            // Email already taken - show red border and error
                            emailInput.removeClass('is-valid').addClass('is-invalid');
                            emailInput.siblings('.invalid-feedback').text('❌ This email address is already taken. Please use a different email.');
                        } else {
                            // Email is available - show green border
                            emailInput.removeClass('is-invalid').addClass('is-valid');
                            emailInput.siblings('.invalid-feedback').text('');
                        }
                    },
                    error: function() {
                        // On error, just validate format (don't block)
                        emailInput.removeClass('is-invalid').addClass('is-valid');
                        emailInput.siblings('.invalid-feedback').text('');
                    }
                });
            }, 500); // Wait 500ms after user stops typing before checking
        }
    });

    // Real-time password validation
    $('#password').on('input', function() {
        var passwordInput = $(this);
        var password = passwordInput.val();
        
        if (password === '') {
            passwordInput.removeClass('is-valid is-invalid');
            passwordInput.siblings('.invalid-feedback').text('');
        } else if (password.length < 6) {
            passwordInput.removeClass('is-valid').addClass('is-invalid');
            passwordInput.siblings('.invalid-feedback').text('Password must be at least 6 characters long.');
        } else {
            passwordInput.removeClass('is-invalid').addClass('is-valid');
            passwordInput.siblings('.invalid-feedback').text('');
        }
    });

    // Real-time role validation
    $('#role').on('change', function() {
        var roleInput = $(this);
      var selectedRole = roleInput.val();
      var courseGroup = $('#courseGroup');
      var courseInput = $('#course_name');

      // Course is required only for students
      if (selectedRole === 'student') {
        courseGroup.removeClass('d-none');
        courseInput.prop('required', true);
      } else {
        courseGroup.addClass('d-none');
        courseInput.prop('required', false).val('');
        courseInput.removeClass('is-valid is-invalid');
        courseInput.siblings('.invalid-feedback').text('');
      }

        if (roleInput.val() === '' || roleInput.val() === null) {
            roleInput.removeClass('is-valid').addClass('is-invalid');
            roleInput.siblings('.invalid-feedback').text('Please select a role.');
        } else {
            roleInput.removeClass('is-invalid').addClass('is-valid');
            roleInput.siblings('.invalid-feedback').text('');
        }
    });

    // Real-time course validation (when role is student)
    $('#course_name').on('change', function() {
      var courseInput = $(this);
      var selectedRole = $('#role').val();

      if (selectedRole !== 'student') {
        courseInput.removeClass('is-valid is-invalid');
        courseInput.siblings('.invalid-feedback').text('');
        return;
      }

      if (courseInput.val() === '' || courseInput.val() === null) {
        courseInput.removeClass('is-valid').addClass('is-invalid');
        courseInput.siblings('.invalid-feedback').text('Please select a course for student role.');
      } else {
        courseInput.removeClass('is-invalid').addClass('is-valid');
        courseInput.siblings('.invalid-feedback').text('');
      }
    });

    $('#addUserForm').on('submit', function(e) {
      var role = $('#role').val();
      var courseInput = $('#course_name');
      if (role === 'student' && !courseInput.val()) {
        e.preventDefault();
        courseInput.removeClass('is-valid').addClass('is-invalid');
        courseInput.siblings('.invalid-feedback').text('Please select a course for student role.');
      }
    });

    // Reset form validation when modal is closed
    $('#addUserModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $(this).find('.invalid-feedback').text('');
      $('#courseGroup').addClass('d-none');
      $('#course_name').prop('required', false);
    });
});
</script>

<style>
.admin-dashboard .admin-hero {
  background: linear-gradient(135deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}

.admin-dashboard .admin-mini-card {
  background: rgba(255, 255, 255, 0.16);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.admin-dashboard .summary-card {
  background: #ffffff;
  border: 1px solid #d7e6fb;
}

.admin-dashboard .user-management-panel {
  background: #f9fcff;
  border: 1px solid #d7e6fb;
}

.admin-dashboard .admin-table thead th {
  white-space: nowrap;
}

.admin-dashboard .admin-table td,
.admin-dashboard .admin-table th {
  vertical-align: middle;
}

.admin-dashboard .btn-primary {
  background-color: #155fa7;
  border-color: #155fa7;
}

.admin-dashboard .btn-primary:hover,
.admin-dashboard .btn-primary:focus {
  background-color: #124e89;
  border-color: #124e89;
}

.admin-dashboard .form-control:focus,
.admin-dashboard .form-select:focus {
  border-color: #6da7df;
  box-shadow: 0 0 0 0.2rem rgba(21, 95, 167, 0.2);
}

.teacher-dashboard .teacher-hero {
  background: linear-gradient(135deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}

.teacher-dashboard .teacher-mini-card {
  background: rgba(255, 255, 255, 0.16);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.teacher-dashboard .teacher-note {
  background: #edf6ff;
  border: 1px solid #cfe6ff;
  color: #124e89;
}

.teacher-dashboard .teacher-courses-panel {
  background: #f9fcff;
  border: 1px solid #d7e6fb;
}

.teacher-dashboard .teacher-course-item {
  border: 1px solid #e3edfb;
  border-radius: 0.9rem;
  margin-bottom: 0.6rem;
  padding-right: 5rem;
}

.teacher-dashboard .teacher-course-title {
  color: #124e89;
}

.teacher-dashboard .teacher-course-notif {
  position: absolute;
  top: 0.65rem;
  right: 0.75rem;
  z-index: 3;
  min-width: 1.6rem;
}

.teacher-dashboard .teacher-materials-panel {
  background: #f9fcff;
  border: 1px solid #d7e6fb;
}

.student-dashboard .student-hero {
  background: linear-gradient(135deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}

.student-dashboard .student-mini-card {
  background: rgba(255, 255, 255, 0.16);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.student-dashboard .student-profile-grid .border {
  border-color: #d7e6fb !important;
}

.student-dashboard .student-course-card {
  border: 1px solid #d7e6fb;
}

.student-dashboard .student-course-card .card-title {
  color: #124e89;
}

.student-dashboard .student-pending-panel {
  background: #f9fcff;
  border: 1px solid #d7e6fb;
}

.student-dashboard .student-materials-panel .accordion-item {
  border: 1px solid #d7e6fb;
}
</style>

</body>
</html>
