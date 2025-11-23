<?php require 'check_session.php' ?>
<?php require 'autoExpire_session.php' ?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Home</title>
    <link rel="short icon" href="assets/images/MNE.png" />
    <link rel="stylesheet" href="../assets/css/home.css">
  </head>

  <body>

    <?php include 'header.php'; ?>
    <hr class="m-0">
    <div class="container-fluid px-0">

      <div class="hero-box">

        <div class="hero-left">
          <h1>Welcome to the CRM Dashboard</h1>
          <p class="text-capitalize">Manage your customer, tickets, products and service calls in one place.</p>

          <div class="hero-btn">
            <a href="add_ticket.php">Create Ticket</a>
            <a href="ticket_register.php">View Tickets</a>
          </div>
        </div>

        <img src="../assets/images/MNE.png" class="hero-img p-5">

      </div>

    </div>


    <!-- Section 2 -->
    <div class="section2 container">

      <div class="info-section">

        <img src="../assets/images/service.png" class="info-img">

        <div class="info-content">
          <h2>Why Our CRM?</h2>
          <p>
            Our CRM system helps you centralize customer information, manage service requests,
            track product history and handle team communication effectively.
          </p>

          <ul>
            <li>✔ Quick Ticket Register System</li>
            <li>✔ Easy Client & Product Management</li>
            <li>✔ Ticket Completion Tracking</li>
            <li>✔ Safe & Secure Records</li>
          </ul>
        </div>

      </div>

    </div>

    <!-- section 3 -->
    <div class="container cards-section mb-5 pb-5">

      <h2>Key Modules</h2>

      <div class="card-row">

        <div class="crm-card">
          <img src="../assets/images/client.png">
          <h3>Client Management</h3>
          <p>Add, update & track client company records and contact details safely.</p>
        </div>

        <div class="crm-card">
          <img src="../assets/images/ticket.png">
          <h3>Ticket Handling</h3>
          <p>Register, assign & monitor tickets with status control & reporting.</p>
        </div>

        <div class="crm-card">
          <img src="../assets/images/product.png">
          <h3>Product Records</h3>
          <p>Store products, warranties, serial numbers & customer history.</p>
        </div>

      </div>

    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"></script>
  </body>

</html>