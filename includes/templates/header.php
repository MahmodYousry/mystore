<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
    		<link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
    		<link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>front.css" />

        <script src="<?php echo $js;?>jquery-2.2.4.min.js"></script>
        <script>
          $(document).ready(function () {

              // get the name of the file appear on select in login.php upload field
              $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
              });

              // sends all types of data[value] from items.php add-video section
              $("#progressBar").hide();
              $(".statusbar").hide();

              $("#addNewUser").submit(function(e) {
                  e.preventDefault();

                  $("#progressBar").show();
                  $(".statusbar").show();

                  var formData = new FormData(this);
                  var ajax = new XMLHttpRequest();

                  ajax.upload.addEventListener("progress", progressHandler, false);
                  ajax.addEventListener("load", completeHandler, false);
                  ajax.addEventListener("error", errorHandler, false);
                  ajax.addEventListener("abort", abortHandler, false);

                  ajax.open("POST", "ajaxphp/addNewUser.php");
                  ajax.send(formData);

                  return  $(".username").val(""),
                          $(".pass").val(""),
                          $(".pass2").val(""),
                          $("#emailsign").val(""),
                          $("#customFile").val("");
              
                  
              });

              var loading         = document.getElementById('loading_n_total'),
                  progressBaring  = document.getElementById('progressBar'),
                  statusing       = document.getElementById('status');


              function progressHandler(event) {
                  loading.innertHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                  var percent = (event.loaded / event.total) * 100;
                  progressBaring.value = Math.round(percent);
                  statusing.innerHTML = Math.round(percent)+"% Uploaded... Please Wait";
              }
              
              function completeHandler(event) {
                  statusing.innerHTML = event.target.responseText;
                  progressBaring.value = 0;
              }
              
              function errorHandler(event) {
                  statusing.innerHTML = "Upload Failed";
              }
              
              function abortHandler(event) {
                  statusing.innerHTML = "Upload Aborted";
              }

            });
        </script>
    </head>
    <body>
    <div class="upper-bar">
        <div class="container">
          <?php
            if (isset($_SESSION['user'])) { ?>

            <img class="my-image img-thubmnail img-circle" src="noprofile_lg.png" alt="" />
            <div class="btn-group my-info">
              <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php echo $sessionUser; ?>
                <span class="caret"></span>
              </span>
              <ul class="dropdown-menu">
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="newad.php">New Item</a></li>
                <li><a href="profile.php#my-ad">My Items</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>


            <?php


            } else {
          ?>
          <a href="login.php">
            <span class="pull-right">Login/Signup</span>
          </a>
          <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Homepage</a>
        </div>

        <div class="collapse navbar-collapse" id="app-nav">
          <ul class="nav navbar-nav navbar-right">
            <?php
              $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", $ordering = "ASC");
              foreach ($allCats as $cat) {
                  echo 
                  '<li>
                      <a href="categories.php?pageid=' . $cat['ID'] . '">
                          ' . $cat['Name'] . '
                      </a>
                  </li>';
              }
            ?>
          </ul>
        </div>
      </div>
    </nav>