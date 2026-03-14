<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('app\Views\template.php'); ?>

<main class="contact-page container py-5 mt-5">
  <section class="contact-hero rounded-4 p-4 p-lg-5 mb-4 shadow-sm">
    <div class="row g-4 align-items-center">
      <div class="col-lg-8">
        <span class="badge text-bg-light text-danger fw-semibold mb-3">Support Center</span>
        <h1 class="display-6 fw-bold mb-3">Need help with enrollment or course access?</h1>
        <p class="lead mb-0">Our support team is here for both students and teachers. Contact us through your preferred channel.</p>
      </div>
      <div class="col-lg-4">
        
      </div>
    </div>
  </section>

  <section class="row g-3 mb-4">
    <div class="col-md-4 d-flex">
      <article class="contact-card rounded-4 p-4 shadow-sm w-100">
        <h2 class="h5 text-danger">Email Support</h2>
        <p class="mb-2">Best for account concerns and enrollment questions.</p>
        <a class="link-danger fw-semibold" href="mailto:adriennemarinay@gmail.com">adriennemarinay@gmail.com</a>
      </article>
    </div>
    <div class="col-md-4 d-flex">
      <article class="contact-card rounded-4 p-4 shadow-sm w-100">
        <h2 class="h5 text-danger">Phone Line</h2>
        <p class="mb-2">Best for urgent access and classroom issues.</p>
        <p class="fw-semibold mb-0">+63 999 999 9999</p>
      </article>
    </div>
    <div class="col-md-4 d-flex">
      <article class="contact-card rounded-4 p-4 shadow-sm w-100">
        <h2 class="h5 text-danger">Campus Office</h2>
        <p class="mb-0">123 Dira ras gilid, Kanto, Philippines</p>
      </article>
    </div>
  </section>

  <section class="faq-panel rounded-4 p-4 p-lg-5 shadow-sm">
    <h2 class="h4 mb-3">Before you contact us</h2>
    <div class="accordion" id="contactFaq">
      <div class="accordion-item">
        <h3 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
            I cannot log in. What should I do?
          </button>
        </h3>
        <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#contactFaq">
          <div class="accordion-body">Use the correct school email and password. If access still fails, send us your full name and role (student/teacher).</div>
        </div>
      </div>
      <div class="accordion-item">
        <h3 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
            I cannot find my enrolled course.
          </button>
        </h3>
        <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
          <div class="accordion-body">Your enrollment may still be pending approval. Contact support with your course name and section details.</div>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
  background: linear-gradient(180deg, #fff6f5 0%, #fdeeee 48%, #fff9f9 100%);
  color: #4b1f1f;
}

.contact-page {
  max-width: 1120px;
}

.contact-hero {
  background: linear-gradient(130deg, #c1365f 0%, #dc5a48 50%, #f28357 100%);
  color: #ffffff;
}

.contact-hero .lead {
  color: #fff1ee;
}

.contact-card,
.faq-panel {
  background: #ffffff;
  border: 1px solid #f0d6d6;
}
</style>
</body>
</html>
