<nav class="navbar navbar-expand-lg fixed-top header-shell">
  <div class="container-lg">
    <a class="navbar-brand d-flex flex-column me-4" href="<?= base_url('/') ?>">
      <span class="brand-main">Enrollment System</span>
      <small class="brand-sub d-none d-lg-block">Student and Teacher Portal</small>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mt-3 mt-lg-0 nav-gap">
        <li class="nav-item">
          <a class="nav-link nav-pill" 
             href="<?= base_url('/') ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-pill" 
             href="<?= base_url('about') ?>">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-pill" 
             href="<?= base_url('contact') ?>">Contact</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mt-3 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-pill nav-pill-login" 
             href="<?= base_url('login') ?>">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
.header-shell {
  background: linear-gradient(90deg, #124875 0%, #19608f 45%, #1f7ea0 100%);
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 4px 14px rgba(12, 34, 60, 0.2);
}

.header-shell .navbar-toggler-icon {
  filter: invert(1);
}

.brand-main {
  color: #ffffff;
  font-weight: 700;
  letter-spacing: 0.01em;
  line-height: 1.1;
}

.brand-sub {
  color: #d4ebff;
  font-size: 0.76rem;
}

.nav-gap {
  gap: 0.35rem;
}

.nav-pill {
  border: 1px solid rgba(255, 255, 255, 0.45);
  color: #f2f8ff;
  border-radius: 999px;
  padding: 0.45rem 1rem;
  transition: all 180ms ease;
}

.nav-pill:hover,
.nav-pill:focus {
  color: #ffffff;
  background-color: rgba(255, 255, 255, 0.16);
  border-color: rgba(255, 255, 255, 0.85);
}

.nav-pill-login {
  background: #ffffff;
  color: #125583;
  font-weight: 600;
  border-color: #ffffff;
}

.nav-pill-login:hover,
.nav-pill-login:focus {
  background: #e7f3ff;
  color: #0e4a72;
  border-color: #e7f3ff;
}

@media (max-width: 991.98px) {
  .nav-pill,
  .nav-pill-login {
    display: block;
    width: fit-content;
  }
}
</style>
