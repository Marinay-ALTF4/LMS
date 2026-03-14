<?php
$role = strtolower(session()->get('role') ?? '');
$uri = service('uri');
$segments = array_map('strtolower', $uri->getSegments());
if (!empty($segments) && $segments[0] === 'index.php') {
  array_shift($segments);
}
$currentPath = implode('/', $segments);
$isPath = function (string $path) use ($currentPath): bool {
  $needle = strtolower(trim($path, '/'));
  if ($needle === '') {
    return $currentPath === '';
  }
  return $needle !== '' && strpos($currentPath, $needle) === 0;
};
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<nav class="navbar navbar-expand-lg app-shell navbar-dark shadow-sm py-2">
  <div class="container-lg">
    <span class="role-chip px-3 py-2 fw-bold me-3">
      <?= ucfirst($role ?: 'Guest') ?>
    </span>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left side -->
      <ul class="navbar-nav me-auto align-items-lg-center nav-list-gap mt-3 mt-lg-0">
        <?php if ($role === 'admin'): ?>
          <li class="nav-item"><a class="btn nav-pill <?= $isPath('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="btn nav-pill <?= $isPath('admin/courses') ? 'active' : '' ?>" href="<?= base_url('admin/courses') ?>">Courses</a></li>

        <?php elseif ($role === 'teacher'): ?>
          <li class="nav-item"><a class="btn nav-pill <?= $isPath('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="btn nav-pill" href="<?= base_url('dashboard') ?>">Assignments</a></li>

        <?php elseif ($role === 'student'): ?>
          <li class="nav-item"><a class="btn nav-pill <?= $isPath('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="btn nav-pill <?= ($isPath('student/courses') || $isPath('studentCourse')) ? 'active' : '' ?>" href="<?= base_url('student/courses') ?>">My Courses</a></li>
        <?php endif; ?>
      </ul>

      <!-- Right side -->
      <ul class="navbar-nav align-items-center mt-3 mt-lg-0 nav-list-gap">
        <?php if (session()->get('isLoggedIn')): ?>
          <!-- Notification -->
          <li class="nav-item dropdown">
            <a class="btn nav-pill position-relative" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-bell"></i>
              <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $notificationCount ?? 0 ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="width:350px;max-height:400px;overflow-y:auto;">
              <li class="dropdown-header d-flex justify-content-between align-items-center border-bottom bg-light">
                <strong>Notifications</strong>
                <button id="markAllRead" class="btn btn-sm btn-link p-0 text-dark">Mark all</button>
              </li>
              <div id="notifList" class="p-2"></div>
            </ul>
          </li>
          <!-- Logout -->
          <li class="nav-item">
            <a class="btn nav-pill nav-pill-logout" href="<?= base_url('logout') ?>">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="btn nav-pill <?= $isPath('login') ? 'active' : '' ?>" href="<?= base_url('login') ?>">Login</a></li>
          <li class="nav-item"><a class="btn btn-light text-primary fw-semibold rounded-pill px-3 py-2 <?= $isPath('register') ? 'active' : '' ?>" href="<?= base_url('register') ?>">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script>
$(function(){
  const $list = $('#notifList'), $badge = $('#notifBadge');
  function load(){
    $.get('<?= base_url("notifications") ?>', d=>{
      const c=d.unread_count||0;
      $badge.text(c).toggle(c>0);
      $list.empty();
      if(!d.notifications?.length) return $list.html('<div class="alert alert-info text-center mb-0">No notifications</div>');
      d.notifications.forEach(n=>{
        const isRead=n.is_read==1;
        $list.append(`
          <div class="alert ${isRead?'alert-secondary':'alert-info'} mb-2 p-2" data-id="${n.id}">
            <div class="d-flex justify-content-between">
              <div class="${isRead?'text-muted':''}">
                <strong>${n.message}</strong><br>
                <small class="text-muted">${new Date(n.created_at).toLocaleDateString()}</small>
              </div>
              ${!isRead?`<button class="btn btn-sm btn-outline-dark mark" data-id="${n.id}">Read</button>`:''}
            </div>
          </div>`);
      });
    }).fail(()=>{$list.html('<div class="alert alert-danger text-center">Error loading</div>');$badge.hide();});
  }
  $(document).on('click','.mark',function(){
    $.post('<?= base_url("notifications/mark_read") ?>/'+$(this).data('id'),{'<?= csrf_token() ?>':'<?= csrf_hash() ?>'}).done(load);
  });
  $('#markAllRead').click(()=>$.post('<?= base_url("notifications/mark_all") ?>',{'<?= csrf_token() ?>':'<?= csrf_hash() ?>'}).done(load));
  load(); setInterval(load,60000);
});
</script>

<style>
.app-shell {
  background: linear-gradient(90deg, #124875 0%, #19608f 48%, #1f7ea0 100%);
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.role-chip {
  background: #ffffff;
  color: #114d79;
  border-radius: 999px;
  font-size: 0.9rem;
  line-height: 1;
}

.nav-list-gap {
  gap: 0.45rem;
}

.nav-pill {
  border: 1px solid rgba(255, 255, 255, 0.45);
  border-radius: 999px;
  color: #f4f9ff;
  padding: 0.45rem 1rem;
  font-size: 0.92rem;
  transition: all 0.18s ease;
}

.nav-pill:hover {
  background: rgba(255, 255, 255, 0.16);
  color: #ffffff;
  border-color: rgba(255, 255, 255, 0.85);
}

.btn-nav.active,
.btn-nav.active:hover {
  background: #ffffff;
  color: #114d79;
  border-color: #ffffff;
  box-shadow: none;
}

.nav-pill.active,
.nav-pill.active:hover {
  background: #ffffff;
  color: #114d79;
  border-color: #ffffff;
}

.nav-pill-logout {
  background: rgba(255, 255, 255, 0.12);
}

#notifBadge {
  font-size: 0.7rem;
  padding: 0.25em 0.45em;
  min-width: 18px;
}

#notifList .alert {
  font-size: 0.9rem;
  border-radius: 0.45rem;
  cursor: pointer;
  border-left: 4px solid transparent;
  transition: 0.2s;
}

#notifList .alert-info { border-left-color: #0dcaf0; }
#notifList .alert-secondary { border-left-color: #6c757d; }
#notifList .alert:hover { opacity: 0.9; transform: scale(1.01); }

@media (max-width: 991.98px) {
  .nav-pill,
  .nav-pill-logout {
    width: fit-content;
  }
}
</style>
