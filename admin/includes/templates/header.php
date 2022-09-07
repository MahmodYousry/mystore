<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?php getTitle() ?></title>
        <link rel="icon" type="image/x-icon" href="../layout/imgs/icon.png">       
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>backend.css" />

        <script src="<?php echo $js; ?>jquery-2.2.4.min.js"></script>
        <script>
            $(document).ready(function () {


                // Delete item Image
                $("#del-item-image-form").submit(function(event) {
                    event.preventDefault();

                    var subdeliImage = $('#subdeliImage').val(),
                        delitemImageAddress = $('#delitemImageAddress').val(),
                        postid       = <?php if(isset($_GET['itemid'])) {echo $_GET['itemid'];} ?>

                    // send text only to php file which is the postid and it's not defined error 
                    $.ajax({url: "phpajax/deleteFiles.php", type: "POST", async: false,
                        data: {
                            "delitemImageAddress": delitemImageAddress,
                            "subdeliImage": subdeliImage,
                            "postid": postid
                        },
                        success: function(data) {
                            $(".ms-delimg").show().html(data);
                        }
                    });

                });


                // Start new way to upload file
                // sends all types of data[value] from items.php add-video section
                $("#progressBar").hide();
                $(".stltx").hide();
                // set img for items by item id in items.php -> $do == 'setimg'
                $("#setImgForitem-form").submit(function(e) {
                    e.preventDefault();

                    $("#progressBar").show();
                    $("#loading_n_total").show();
                    $("#stltx").show();

                    var formData = new FormData(this);
                    var ajax = new XMLHttpRequest();

                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);

                    ajax.open("POST", "phpajax/set_item_images.php");
                    ajax.send(formData);

                    console.log(ajax.responseText);

                    return document.getElementById('setImages').value = '';
                    
                });

                var loading         = document.getElementById('loading_n_total'),
                    progressBaring  = document.getElementById('progressBar'),
                    statusing       = document.getElementById('stltx');


                function progressHandler(event) {
                  loading.innertHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                  var percent = (event.loaded / event.total) * 100;
                  progressBaring.value = Math.round(percent);
                  statusing.innerHTML = Math.round(percent)+"% Uploaded... Please Wait";
                }
              
                function completeHandler(event) {
                    statusing.innerHTML = event.target.responseText;
                    progressBaring.value = 0;
                    document.getElementById('refreshImages').click();
                    $("#progressBar").hide();
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