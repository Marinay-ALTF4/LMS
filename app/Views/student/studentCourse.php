<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Courses</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!--  Include header template -->
  <?php include('app/Views/templates/header.php'); ?>

  <main class="student-courses-page container py-5 mt-4 mt-lg-5">
    <section class="student-courses-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm text-white">
      <span class="badge text-bg-light text-primary mb-3">Student Center</span>
      <h3 class="mb-2">My Courses</h3>
      <p class="mb-0">Hello, <?= esc(session()->get('name') ?? 'User') ?>. Track your enrolled subjects, pending requests, and available classes to join.</p>
    </section>

    <div id="enroll-alert" class="mb-3"></div>

    <div class="row g-4">
          <!--  Enrolled Courses -->
          <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100 student-panel">
              <div class="card-header fw-bold panel-header">Enrolled Courses</div>
              <ul id="enrolled-courses" class="list-group list-group-flush">
                <?php if (!empty($data['enrolledCourses'])): ?>
                  <?php foreach ($data['enrolledCourses'] as $course): ?>
                    <li class="list-group-item">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="fw-semibold"><?= esc($course['title']) ?></div>
                          <small class="text-dark d-block course-code">Course Code: <?= esc($course['description']) ?></small>
                          <small class="text-dark d-block">Teacher: <?= esc($course['teacher_name'] ?? 'TBD') ?></small>
                          <small class="text-dark d-block">Semester: <?= esc($course['semester'] ?? 'Not set') ?></small>
                          <small class="text-dark d-block">Time: <?= esc($course['class_time'] ?? 'TBD') ?></small>
                          <small class="text-dark d-block">SY: <?= esc($course['school_year'] ?? 'TBD') ?></small>
                        </div>
                        <div class="text-end">
                          <span class="badge text-bg-success mb-2">Enrolled</span>
                          <div>
                                <a href="<?= base_url('student/course/' . (int) ($course['course_id'] ?? $course['id'] ?? 0)) ?>" class="btn btn-primary btn-sm">View Course</a>
                          </div>
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li class="list-group-item text-muted empty-state">You have not enrolled in any course yet.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>

          <!--  Pending + Available Courses -->
          <div class="col-12 col-lg-6">
            <div class="card shadow-sm mb-3 student-panel">
              <div class="card-header fw-bold panel-header">Pending Approval</div>
              <ul id="pending-courses" class="list-group list-group-flush">
                <?php if (!empty($data['pendingCourses'])): ?>
                  <?php foreach ($data['pendingCourses'] as $course): ?>
                    <li class="list-group-item">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="fw-semibold"><?= esc($course['title']) ?></div>
                          <small class="text-dark course-code">Course Code: <?= esc($course['description']) ?></small>
                        </div>
                        <span class="badge text-bg-warning">Pending</span>
                      </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li class="list-group-item text-muted empty-state">No pending requests.</li>
                <?php endif; ?>
              </ul>
            </div>

            <div class="card shadow-sm student-panel">
              <div class="card-header fw-bold panel-header">Available Courses</div>
              <ul id="available-courses" class="list-group list-group-flush">
                <?php if (!empty($data['availableCourses'])): ?>
                  <?php foreach ($data['availableCourses'] as $course): ?>
                    <li class="list-group-item">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="fw-semibold"><?= esc($course['title']) ?></div>
                          <small class="text-dark d-block course-code">Course Code: <?= esc($course['description']) ?></small>
                          <small class="text-dark d-block">Teacher: <?= esc($course['teacher_name'] ?? 'TBD') ?></small>
                          <small class="text-dark d-block">Semester: <?= esc($course['semester'] ?? 'Not set') ?></small>
                          <small class="text-dark d-block">Time: <?= esc($course['class_time'] ?? 'TBD') ?></small>
                          <small class="text-dark d-block">SY: <?= esc($course['school_year'] ?? 'TBD') ?></small>
                        </div>
                        <!--  Enroll button with course ID -->
                        <button class="btn btn-primary btn-sm enroll-btn"
                                data-course-id="<?= (int)$course['id'] ?>">Enroll</button>
                      </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li class="list-group-item text-muted">No courses available.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
  </main>

          <!--  jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  
       <!-- AJAX SCRIPT FOR ENROLLMENT-->
  
  <script>
  $(function () {
        //  Listen for clicks on any "Enroll" button
    $('#available-courses').on('click', '.enroll-btn', function (e) {
      e.preventDefault(); // stop page reload

      var $btn = $(this);
      var courseId = $btn.data('course-id'); // get the course ID

      //  Send AJAX POST request to enroll endpoint
      $.post('<?= base_url('courses/enroll') ?>', { 
        course_id: courseId,
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      })
        .done(function (data) {
          //  Prepare alert message
          var message = (data && data.message) ? data.message :
                        (data.success ? 'Enrolled successfully.' : 'Enrollment failed.');
          var alertClass = (data && data.success) ? 'alert-success' : 'alert-danger';

          //  Show alert message
          $('#enroll-alert').html(
            '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
              message +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>'
          );

          //  If enrollment was successful
          if (data && data.success) {
            var status = data.status || 'pending';
            var $item = $btn.closest('li');
            var title = $item.find('.fw-semibold').text();
            var desc = $item.find('.course-code').text();
            var targetList = status === 'accepted' ? '#enrolled-courses' : '#pending-courses';
            var badgeClass = status === 'accepted' ? 'text-bg-success' : 'text-bg-warning';
            var badgeLabel = status === 'accepted' ? 'Enrolled' : 'Pending';

            $(targetList + ' .empty-state').remove();

            $(targetList).prepend(
              '<li class="list-group-item">' +
                '<div class="d-flex justify-content-between align-items-start">' +
                  '<div>' +
                    '<div class="fw-semibold">' + $('<div>').text(title).html() + '</div>' +
                    '<small class="text-dark d-block">' + $('<div>').text(desc).html() + '</small>' +
                  '</div>' +
                  '<span class="badge ' + badgeClass + '">' + badgeLabel + '</span>' +
                '</div>' +
              '</li>'
            );

            // Disable the button to avoid duplicate requests
            $btn.prop('disabled', true).text(badgeLabel);

            // Remove the course from available courses list
            $item.remove();
          }
        })
        .fail(function (xhr, status, error) {
          console.log('AJAX Error:', xhr.status, xhr.statusText, error);
          var errorMessage = 'Network error.';
          
          if (xhr.status === 404) {
            errorMessage = 'Enrollment endpoint not found.';
          } else if (xhr.status === 403) {
            errorMessage = 'Access forbidden. Please refresh the page and try again.';
          } else if (xhr.status === 500) {
            errorMessage = 'Server error. Please try again later.';
          }
          
          $('#enroll-alert').html(
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
              errorMessage + ' (Status: ' + xhr.status + ')' +
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>'
          );
        });
    });
  });
  </script>

<style>
body {
  background: linear-gradient(180deg, #f5f9ff 0%, #edf4ff 48%, #f8fbff 100%);
  color: #163047;
}

.student-courses-page {
  max-width: 1120px;
}

.student-courses-hero {
  background: linear-gradient(135deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}

.student-panel {
  border: 1px solid #d7e6fb;
}

.panel-header {
  background: #f4f9ff;
  border-bottom: 1px solid #d7e6fb;
}

.student-courses-page .list-group-item {
  border-color: #e8f0fb;
}

.student-courses-page .btn-primary {
  background-color: #155fa7;
  border-color: #155fa7;
}

.student-courses-page .btn-primary:hover,
.student-courses-page .btn-primary:focus {
  background-color: #124e89;
  border-color: #124e89;
}
</style>
</body>
</html>
