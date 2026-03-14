<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('app\Views\template.php'); ?>

<main class="about-page container py-5 mt-5">
  <section class="about-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm">
    <span class="badge text-bg-light text-success fw-semibold mb-3">About The Platform</span>
    <h1 class="display-6 fw-bold mb-3">Designed for better teaching and smoother enrollment</h1>
    <p class="lead mb-0">This enrollment system helps academic teams manage learning operations with less admin friction and better communication.</p>
  </section>

  <section class="row g-3 mb-4">
    <div class="col-md-6 d-flex">
      <article class="info-card rounded-4 p-4 shadow-sm w-100">
        <h2 class="h4 text-success">Our Mission</h2>
        <p class="mb-0">Provide a reliable digital space where students can access course essentials and teachers can manage classes with confidence.</p>
      </article>
    </div>
    <div class="col-md-6 d-flex">
      <article class="info-card rounded-4 p-4 shadow-sm w-100">
        <h2 class="h4 text-success">Our Vision</h2>
        <p class="mb-0">Build a connected campus experience where enrollment, communication, and class resources are always easy to navigate.</p>
      </article>
    </div>
  </section>

  
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
  background: linear-gradient(180deg, #f6fff6 0%, #edf8ef 45%, #f8fdf8 100%);
  color: #1a3d1a;
}

.about-page {
  max-width: 1120px;
}

.about-hero {
  background: linear-gradient(130deg, #1a8758 0%, #39a56f 55%, #7acb8f 100%);
  color: #ffffff;
}

.about-hero .lead {
  color: #effff3;
}

.info-card,
.timeline-panel {
  background: #ffffff;
  border: 1px solid #d5ecda;
}

.timeline-step {
  background: #f3fbf4;
  border: 1px solid #d2e9d6;
}
</style>
</body>
</html>
