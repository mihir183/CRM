<?php
session_start();
require '../db.php';

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalUsers = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --bg: #f5f6fa;
      --card: #fff;
      --text: #1e1e2f;
      --muted: #6c757d;
      --nav: #fff;
      --nav-shadow: 0 2px 5px rgba(0,0,0,.1);
      --sidebar: #1e1e2f;
      --sidebar-hover: #2d2d44;
      --link: #bbb;
      --link-active: #fff;
      --overlay: rgba(0,0,0,.5);
      --footer: #1e1e2f;
      --footer-text: #fff;
      --table-bg: #fff;
      --table-border: #dee2e6;
      --table-hover: #f8f9fa;
    }
    .dark {
      --bg: #0f1115;
      --card: #151821;
      --text: #e6e6e6;
      --muted: #a2a9b1;
      --nav: #121521;
      --nav-shadow: 0 2px 8px rgba(0,0,0,.35);
      --sidebar: #0d0f17;
      --sidebar-hover: #171a25;
      --link: #9aa3ad;
      --link-active: #fff;
      --overlay: rgba(0,0,0,.6);
      --footer: #0d0f17;
      --footer-text: #e6e6e6;
      --table-bg: #151821;
      --table-border: #2a2e3a;
      --table-hover: #1a1d28;
    }
    
    body {
      background: var(--bg);
      color: var(--text);
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Arial;
      margin: 0;
      transition: background 0.3s, color 0.3s;
    }

    /* Loader */
    #loader {
      position: fixed;
      inset: 0;
      background: #1e1e2f;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2000;
    }
    .spinner-border {
      width: 3rem;
      height: 3rem;
      color: #fff;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -260px;
      width: 260px;
      height: 100%;
      background: var(--sidebar);
      color: #fff;
      transition: left 0.35s ease;
      z-index: 1200;
      padding-top: 64px;
      overflow-y: auto;
    }
    .sidebar.active {
      left: 0;
    }
    .sidebar h3 {
      text-align: center;
      padding: 15px;
      margin: 0;
      border-bottom: 1px solid #333;
    }
    .side-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 18px;
      color: var(--link);
      text-decoration: none;
      border-radius: 8px;
      margin: 6px 10px;
      transition: 0.2s;
    }
    .side-link:hover, .side-link.active {
      background: var(--sidebar-hover);
      color: var(--link-active);
    }
    .side-link i {
      width: 22px;
      text-align: center;
    }
    .dropdown-btn {
      cursor: pointer;
    }
    .dropdown-container {
      display: none;
      padding-left: 12px;
    }
    .dropdown-container a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 16px;
      color: var(--link);
      text-decoration: none;
      border-radius: 6px;
      margin: 6px 10px;
    }
    .dropdown-container a:hover {
      background: var(--sidebar-hover);
      color: #fff;
    }

    /* Overlay */
    .overlay {
      position: fixed;
      inset: 0;
      background: var(--overlay);
      display: none;
      z-index: 1100;
    }
    .overlay.active {
      display: block;
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background: var(--nav);
      box-shadow: var(--nav-shadow);
      z-index: 1050;
      min-height: 64px;
      transition: background 0.3s;
    }
    .toggle-btn {
      font-size: 22px;
      color: var(--text);
      cursor: pointer;
      transition: color 0.3s;
    }
    .navbar .brand {
      font-weight: 800;
    }
    .icon-btn {
      position: relative;
      width: 40px;
      height: 40px;
      display: grid;
      place-items: center;
      color: var(--text);
      transition: color 0.3s;
    }
    .icon-btn .badge {
      position: absolute;
      top: 2px;
      right: 2px;
    }
    .theme-toggle {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      color: var(--muted);
      transition: color 0.3s;
    }
    .theme-toggle input {
      display: none;
    }
    .theme-toggle .toggle {
      width: 46px;
      height: 24px;
      background: #cfd3da;
      border-radius: 999px;
      position: relative;
      transition: 0.2s;
    }
    .theme-toggle .toggle::after {
      content: "";
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      transition: 0.2s;
    }
    .dark .theme-toggle .toggle {
      background: #4f5d75;
    }
    .dark .theme-toggle .toggle::after {
      left: 25px;
    }

    /* Main content */
    main {
      padding: 96px 20px 24px 20px;
      transition: background 0.3s;
    }
    .card {
      border: none;
      border-radius: 14px;
      background: var(--card);
      color: var(--text);
      transition: background 0.3s, color 0.3s;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .stat-card {
      color: #fff;
      transition: transform 0.2s;
    }
    .stat-card:hover {
      transform: translateY(-5px);
    }
    .stat1 {
      background: linear-gradient(135deg, #0d6efd, #6ea8fe);
    }
    .stat2 {
      background: linear-gradient(135deg, #198754, #5ee37d);
    }
    .stat3 {
      background: linear-gradient(135deg, #ffc107, #ffda6a);
      color: #1e1e2f;
    }
    .stat4 {
      background: linear-gradient(135deg, #dc3545, #ff6b81);
    }

    /* Tables */
    .table-container {
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .table {
      background: var(--table-bg);
      color: var(--text);
      margin-bottom: 0;
      transition: background 0.3s, color 0.3s;
    }
    .table th {
      background: var(--card);
      color: var(--text);
      border-bottom: 2px solid var(--table-border);
      padding: 16px;
      font-weight: 600;
    }
    .table td {
      padding: 16px;
      border-top: 1px solid var(--table-border);
      vertical-align: middle;
    }
    .table-hover tbody tr:hover {
      background-color: var(--table-hover);
    }

    /* Footer */
    footer {
      background: var(--footer);
      color: var(--footer-text);
      padding: 40px 0;
      margin-top: 20px;
      transition: background 0.3s, color 0.3s;
    }
    footer a {
      color: #bfc6ce;
      text-decoration: none;
      transition: color 0.3s;
    }
    footer a:hover {
      color: #fff;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 220px;
      }
      main {
        padding: 80px 15px;
      }
    }
  </style>
</head>
<body>

<!-- Loader -->
<!-- <div id="loader"><div class="spinner-border"></div></div> -->

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h3>CRM</h3>
  <a href="#" class="side-link active"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
  <a href="#" class="side-link"><i class="fas fa-ticket-alt"></i><span>Tickets</span></a>
  <a href="#" class="side-link"><i class="fas fa-clipboard-list"></i><span>Requests</span></a>
  <a href="#" class="side-link"><i class="fas fa-users"></i><span>Customers</span></a>
  <a href="#" class="side-link"><i class="fas fa-file-alt"></i><span>Reports</span></a>
  <a class="side-link dropdown-btn"><i class="fas fa-cog"></i><span>Settings</span><i class="fas fa-caret-down ms-auto"></i></a>
  <div class="dropdown-container">
    <a href="#"><i class="fas fa-key"></i> Change Password</a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg px-3">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-3">
      <i class="fas fa-bars toggle-btn" id="toggleBtn"></i>
      <h4 class="brand mb-0 text-primary">Dashboard</h4>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
      <div class="theme-toggle" id="themeToggle">
        <div class="toggle"></div>
        <span class="small" id="themeLabel">Light Mode</span>
      </div>
      <div class="dropdown">
        <button class="btn icon-btn" type="button" data-bs-toggle="dropdown">
          <i class="fa-regular fa-bell"></i>
          <span class="badge rounded-pill bg-danger" id="notifCount">3</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end p-0" style="min-width:300px;">
          <li class="px-3 py-2 fw-semibold">Notifications</li>
          <li><hr class="dropdown-divider m-0"></li>
          <li><a class="dropdown-item py-2" href="#">New ticket assigned</a></li>
          <li><a class="dropdown-item py-2" href="#">Invoice paid</a></li>
          <li><a class="dropdown-item py-2" href="#">SLA warning</a></li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        <span class="me-3 text-secondary">Hello, Nayan</span>
        <img src="https://media.licdn.com/dms/image/v2/D4E03AQGm-Uwbbc4BJA/profile-displayphoto-scale_200_200/B4EZeW_827G4Ac-/0/1750585038397?e=2147483647&v=beta&t=xJjNQb9-YU4TvNTVf9ADtwy1S1ae2u9swTJgGRvxOWk"
             class="rounded-circle" style="width:40px; height:40px;">
      </div>
    </div>
  </div>
</nav>

<!-- Main content -->
<main class="container-fluid">
  <!-- Stats -->
  <div class="row g-3 mb-4 text-capitalize">
    <div class="col-6 col-md-3">
      <div class="card stat-card stat1">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div>total users</div>
              <h3 id="statTotal"><?php echo $totalUsers?></h3>
            </div>
            <i class="fa-solid fa-users fa-2x opacity-75"></i>
          </div>
          <div class="mt-2 small">+12% from last week</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card stat2">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div>Resolved</div>
              <h3 id="statResolved">280</h3>
            </div>
            <i class="fas fa-check-circle fa-2x opacity-75"></i>
          </div>
          <div class="mt-2 small">80% resolution rate</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card stat3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div>Pending</div>
              <h3 id="statPending">35</h3>
            </div>
            <i class="fas fa-clock fa-2x opacity-75"></i>
          </div>
          <div class="mt-2 small">10% of total tickets</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card stat4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div>Overdue</div>
              <h3 id="statOverdue">35</h3>
            </div>
            <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
          </div>
          <div class="mt-2 small">Needs immediate attention</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Data Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Tickets Overview</span>
          <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-3">
            <div class="d-flex align-items-center">
              <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
              <small>Resolved: 280 (80%)</small>
            </div>
            <div class="d-flex align-items-center">
              <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
              <small>Pending: 35 (10%)</small>
            </div>
            <div class="d-flex align-items-center">
              <div class="bg-danger rounded-circle me-2" style="width: 12px; height: 12px;"></div>
              <small>Overdue: 35 (10%)</small>
            </div>
          </div>
          <div class="progress mb-4" style="height: 20px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          
          <div class="bg-light p-3 rounded dark:bg-dark">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-medium">Average Resolution Time</span>
              <span class="badge bg-info">18.5 hours</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-medium">First Response Time</span>
              <span class="badge bg-primary">2.3 hours</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Requests Trend</span>
          <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body">
          <div class="row text-center mb-4">
            <div class="col-4">
              <div class="fw-bold text-primary">42</div>
              <small class="text-muted">This Week</small>
            </div>
            <div class="col-4">
              <div class="fw-bold text-success">+15%</div>
              <small class="text-muted">Change</small>
            </div>
            <div class="col-4">
              <div class="fw-bold">158</div>
              <small class="text-muted">This Month</small>
            </div>
          </div>
          
          <div class="bg-light p-3 rounded dark:bg-dark">
            <div class="d-flex justify-content-between mb-2">
              <span>Mon</span>
              <span>Tue</span>
              <span>Wed</span>
              <span>Thu</span>
              <span>Fri</span>
              <span>Sat</span>
              <span>Sun</span>
            </div>
            <div class="d-flex justify-content-between align-items-end" style="height: 40px;">
              <div class="bg-primary rounded" style="width: 12%; height: 30%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 50%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 70%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 100%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 80%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 40%;"></div>
              <div class="bg-primary rounded" style="width: 12%; height: 60%;"></div>
            </div>
          </div>
          
          <div class="mt-3 d-flex justify-content-between">
            <div>
              <span class="badge bg-success">Completed: 125</span>
            </div>
            <div>
              <span class="badge bg-warning">In Progress: 22</span>
            </div>
            <div>
              <span class="badge bg-info">New: 11</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Tables -->
  <div class="row g-3 mb-5">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Recent Tickets</span>
          <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
          <div class="table-container">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Agent</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="fw-bold">#101</td>
                  <td>Login issue</td>
                  <td><span class="badge bg-warning">Open</span></td>
                  <td>Alice</td>
                </tr>
                <tr>
                  <td class="fw-bold">#102</td>
                  <td>Password reset</td>
                  <td><span class="badge bg-success">Closed</span></td>
                  <td>Bob</td>
                </tr>
                <tr>
                  <td class="fw-bold">#103</td>
                  <td>Billing error</td>
                  <td><span class="badge bg-danger">Overdue</span></td>
                  <td>John</td>
                </tr>
                <tr>
                  <td class="fw-bold">#104</td>
                  <td>Feature request</td>
                  <td><span class="badge bg-info">In Review</span></td>
                  <td>Sarah</td>
                </tr>
                <tr>
                  <td class="fw-bold">#105</td>
                  <td>Performance issue</td>
                  <td><span class="badge bg-primary">In Progress</span></td>
                  <td>Mike</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Recent Requests</span>
          <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
          <div class="table-container">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Request</th>
                  <th>Status</th>
                  <th>Customer</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="fw-bold">#201</td>
                  <td>New feature</td>
                  <td><span class="badge bg-info">Pending</span></td>
                  <td>Mike</td>
                </tr>
                <tr>
                  <td class="fw-bold">#202</td>
                  <td>Upgrade plan</td>
                  <td><span class="badge bg-success">Done</span></td>
                  <td>Sara</td>
                </tr>
                <tr>
                  <td class="fw-bold">#203</td>
                  <td>Cancel service</td>
                  <td><span class="badge bg-warning">In Progress</span></td>
                  <td>Linda</td>
                </tr>
                <tr>
                  <td class="fw-bold">#204</td>
                  <td>Custom report</td>
                  <td><span class="badge bg-primary">Approved</span></td>
                  <td>Robert</td>
                </tr>
                <tr>
                  <td class="fw-bold">#205</td>
                  <td>API access</td>
                  <td><span class="badge bg-secondary">On Hold</span></td>
                  <td>James</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-3">
        <h6>CRM</h6>
        <p>System Faad degee</p>
        <div class="d-flex gap-3 fs-5">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
      <div class="col-md-3"><h5>Quick Links</h5><a href="#">Dashboard</a><a href="#">Tickets</a><a href="#">Requests</a><a href="#">Reports</a></div>
      <div class="col-md-3"><h5>About CRM</h5><p>Our CRM system helps you manage tickets, customers, and requests effectively.</p></div>
      <div class="col-md-3"><h5>Contact</h5><p>Email: udpproject96@gmail.com</p><p>Phone: +91 9274021445</p><p>Address: 7 Devbhoomi Society</p></div>
    </div>
  </div>
  <div class="text-center pt-4 border-top mt-4">&copy; 2025 CRM | Designed by Nayan Pitroda® | All rights reserved</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Loader
  window.addEventListener("load", () => {
    document.getElementById("loader").style.display = "none";
  });

  // Sidebar toggle + auto close
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const toggleBtn = document.getElementById("toggleBtn");

  function openSidebar() {
    sidebar.classList.add("active");
    overlay.classList.add("active");
  }

  function closeSidebar() {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
  }

  toggleBtn.addEventListener("click", () => {
    sidebar.classList.contains("active") ? closeSidebar() : openSidebar();
  });

  overlay.addEventListener("click", closeSidebar);

  // auto close when mouse leaves sidebar
  sidebar.addEventListener("mouseleave", () => {
    if (sidebar.classList.contains("active")) closeSidebar();
  });

  // Dropdown in settings
  document.querySelector(".dropdown-btn").addEventListener("click", function() {
    const dropdown = this.nextElementSibling;
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  });

  // Theme toggle
  const themeToggle = document.getElementById("themeToggle");
  const themeLabel = document.getElementById("themeLabel");
  
  function applyTheme(mode) {
    document.body.classList.toggle("dark", mode === "dark");
    localStorage.setItem("theme", mode);
    themeLabel.textContent = mode === "dark" ? "Dark Mode" : "Light Mode";
  }
  
  // Apply saved theme or default to light
  applyTheme(localStorage.getItem("theme") || "light");
  
  themeToggle.addEventListener("click", () => {
    applyTheme(document.body.classList.contains("dark") ? "light" : "dark");
  });
</script>
</body>
</html>