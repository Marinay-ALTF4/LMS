<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('app\Views\template.php'); ?>

<main class="register-page container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <section class="register-shell rounded-4 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 register-side p-4 p-lg-5 text-white d-flex flex-column justify-content-center">
                        <span class="badge text-bg-light text-primary mb-3 align-self-start">Create Account</span>
                        <h1 class="h3 fw-bold mb-3">Student Registration</h1>
                        <p class="mb-0">Join the enrollment portal to request classes, track approvals, and access your course materials.</p>
                    </div>

                    <div class="col-md-7 bg-white p-4 p-lg-5">
                        <h2 class="h4 fw-semibold mb-4 text-primary">Sign Up</h2>

                        <?php if(session()->getFlashdata('success')): ?>
                            <div class="alert alert-success border-0 py-2 px-3">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger border-0 py-2 px-3">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url('register') ?>">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?= set_value('name') ?>" pattern="[A-Za-z0-9@\.\'\-_ ]{5,}" title="At least 5 characters. Allowed: letters, numbers, spaces, @ . ' - _" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?= set_value('email') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Course Selection</label>
                                <select name="course_name" class="form-select" required>
                                    <option value="">Select your course</option>
                                    <option value="BSIT" <?= set_select('course_name', 'BSIT') ?>>BSIT</option>
                                    <option value="BSCS" <?= set_select('course_name', 'BSCS') ?>>BSCS</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Confirm Password</label>
                                <input type="password" name="password_confirm" class="form-control" placeholder="Confirm your password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
                        </form>

                        <div class="text-center">
                            <small class="text-muted">Already have an account?
                                <a href="<?= site_url('login') ?>" class="link-primary fw-semibold text-decoration-underline">Login here</a>
                            </small>
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

.register-page {
    max-width: 1120px;
}

.register-shell {
    border: 1px solid #d8e6fb;
    background: #ffffff;
}

.register-side {
    background: linear-gradient(140deg, #155fa7 0%, #1d8ea8 60%, #39a3a1 100%);
}

.register-page .btn-primary {
    background-color: #155fa7;
    border-color: #155fa7;
}

.register-page .btn-primary:hover,
.register-page .btn-primary:focus {
    background-color: #124e89;
    border-color: #124e89;
}
</style>

</body>
</html>
