<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('app\Views\template.php'); ?>

<main class="home-page container py-5 mt-5">
    <section class="hero-panel p-4 p-lg-5 rounded-4 shadow-sm mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="badge text-bg-light text-primary fw-semibold mb-3">Enrollment System</span>
                <h1 class="display-5 fw-bold mb-3">One academic hub for teachers and students</h1>
                <p class="lead mb-4">Organize class materials, monitor enrollment, and keep every course update visible in one clean workspace.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('login') ?>" class="btn btn-light text-primary fw-semibold">Go to Login</a>
                    <a href="<?= base_url('about') ?>" class="btn btn-outline-light">How it works</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="stat-card p-3 rounded-3 bg-white text-dark">
                    <h2 class="h5 mb-3">Today at a glance</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom"><span>Courses Active</span><strong>24</strong></li>
                        <li class="d-flex justify-content-between py-2 border-bottom"><span>Pending Enrollments</span><strong>18</strong></li>
                        <li class="d-flex justify-content-between py-2"><span>Materials Uploaded</span><strong>132</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
    background: linear-gradient(180deg, #f5f9ff 0%, #edf4ff 48%, #f8fbff 100%);
    color: #163047;
}

.home-page {
    max-width: 1120px;
}

.hero-panel {
    background: linear-gradient(140deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
    color: #ffffff;
}

.hero-panel .lead {
    color: #e8f4ff;
}

.stat-card {
    border: 1px solid #d7e6ff;
}

.feature-card,
.quick-links {
    background: #ffffff;
    border: 1px solid #d9e7fb;
}
</style>

</body>
</html>
