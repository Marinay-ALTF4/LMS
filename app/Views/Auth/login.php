<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('app\Views\template.php'); ?>

<main class="login-page container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <section class="login-shell rounded-4 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 login-side p-4 p-lg-5 text-white d-flex flex-column justify-content-center">
                        <span class="badge text-bg-light text-primary mb-3 align-self-start">Welcome Back</span>
                        <h1 class="h3 fw-bold mb-3">Teacher and Student Login</h1>
                        <p class="mb-0">Sign in to manage courses, review enrollment updates, and access class materials in one place.</p>
                    </div>

                    <div class="col-md-7 bg-white p-4 p-lg-5">
                        <h2 class="h4 fw-semibold mb-4 text-primary">Sign In</h2>

                        <?php if(session()->getFlashdata('success')): ?>
                            <div class="alert alert-success border-0">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger border-0">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger border-0">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url('login') ?>">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?= set_value('email') ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                        </form>

                        <div class="text-center">
                            <small class="text-muted">Don't have an account? <a href="<?= site_url('register') ?>" class="link-primary fw-semibold text-decoration-underline">Register here</a></small>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
    background: linear-gradient(180deg, #f5f9ff 0%, #edf4ff 48%, #f8fbff 100%);
    color: #163047;
}

.login-page {
    max-width: 1120px;
}

.login-shell {
    border: 1px solid #d8e6fb;
    background: #ffffff;
}

.login-side {
    background: linear-gradient(140deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}
</style>

</body>
</html>
