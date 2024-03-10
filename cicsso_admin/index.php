<?php
// core configuration
include_once "../config/core.php";
// check if logged in as admin
include_once "login_checker.php";
// set page title
$page_title="Cicsso Admin";
// include page header HTML
include 'layout_head.php';
    echo "<div class='col-md-12'>";
        include_once "section/read_section.php";
    echo "</div>";
// include page footer HTML
include_once 'layout_foot.php';
?>