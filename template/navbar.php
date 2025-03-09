<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    $_SESSION['username'] = "Guest"; 
    $_SESSION['email'] = "guest@example.com";
}

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    $_SESSION['username'] = "Guest"; 
    $_SESSION['email'] = "guest@example.com";
}
function getGreeting() {
  $hour = date("H"); 
  if ($hour >= 5 && $hour < 12) {
      return "Good Morning";
  } elseif ($hour >= 12 && $hour < 18) {
      return "Good Afternoon";
  } else {
      return "Good Evening";
  }
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="#">
        <img src="assets/images/logo-mini-reverse.svg" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="#">
        <img src="assets/images/logo-mini-reverse.svg" alt="logo" />
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">
          <?php echo getGreeting(); ?>, <span class="text-black fw-bold"><?php echo htmlspecialchars($username); ?></span>
        </h1>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="assets/images/logo-mini-reverse.svg" alt="Profile image" />
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <img class="img-md rounded-circle" src="assets/images/logo-mini-reverse.svg" alt="Profile image" />
            <p class="mb-1 mt-3 font-weight-semibold"><?php echo htmlspecialchars($username); ?></p>
            <p class="fw-light text-muted mb-0"><?php echo htmlspecialchars($email); ?></p>
          </div>
          <a href="logout.php" class="dropdown-item">
            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
