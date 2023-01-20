<?php 

  @$page = $_GET['page'];
  if (!empty($page)) {

    switch ($page) {
      case 'dashboard':
        include './home.php';
        break;
            
      case 'masuk':
        include 'login.php';
        break;

      case 'daftar':
        include 'register.php';
        break;

      default:
        include './pages/page_administrator/home.php';
        break;
    }

  } else {
    include './pages//page_administrator/home.php';
  }

?>