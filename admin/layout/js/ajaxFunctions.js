

// Start read -> not working yet need edits
function showData() {

    var ourdata = {datais : 'getUserInfo'};

    // send the data with ajax
    $.ajax({url: "phpajax/getUserInfo.php", type: "POST", async: false,
        data: ourdata,
        success: function(data) {
            console.log();
            console.log(typeof data);
            // Convert String into Json Data
            myJsondata = JSON.parse(data);

            let table = '';
            for(let i = 0; i < 1; i++) {
                table += `
                    <tr>
                        <td>${myJsondata.id}</td>
                        <td>${myJsondata.avatar}</td>
                        <td>${myJsondata.user}</td>
                        <td>${myJsondata.email}</td>
                        <td>${myJsondata.fullname}</td>
                        <td>${myJsondata.date}</td>
                    </tr>
                `;
            }
            
            // put data from above to this table
            document.getElementById('tbody').innerHTML = table;

        },
        error: function(data) {
            console.log(data);
        },
        cache: false, contentType: false, processData: false
    });
    
}


// Start Delete Avatar function in members.php
function deleteAvatar(i) {
    // define things to send first
    let mydata = {userid : i};

    // send the data with ajax
    $.ajax({url: "phpajax/deleteAvatar.php", type: "POST", async: false,
        data: mydata,
        success: function(data) {
            alert(data);
            console.log(data);
        },
        error: function(data) {
            console.log(data);
        }
    });
    
}

// delete item using this id
function deleteAll(i) {
    // set the data we get in var
    var mainData = {item_id : i};
   
    // send the data with ajax
    $.ajax({url: "phpajax/deleteItems.php", type: "POST", async: false,
        data: mainData,
        success: function(data) {
            console.log(data);
            document.getElementById(i).parentElement.parentElement.style.display = 'none';
        },
        error: function(data) {alert(data)}
    });    

}

// function for approve item
function approveItem(i) {
    // remove 'approve' from i first
    var ival = i.replace('approve','');
    // get itemid to approve it
    var aprroveitem = {item_id : ival};
    console.log(aprroveitem.item_id);

    // send the data with ajax
    $.ajax({url: "phpajax/approveItem.php", type: "POST", async: false,
        data: aprroveitem,
        success: function(data) {
            console.log(data);
            $('#'+ i).siblings().removeClass('hideThis');
            $('#'+ i).addClass('hideThis');
        },
        error: function(data) {alert(data)}
    });

}

// function for approve item
function disapproveItem(i) {
    // remove 'approve' from i first
    var ivalc = i.replace('disapprove','');
    // get itemid to approve it
    var disaprroveitem = {item_id : ivalc};
    console.log(disaprroveitem.item_id);

    // send the data with ajax
    $.ajax({url: "phpajax/disapproveItem.php", type: "POST", async: false,
        data: disaprroveitem,
        success: function(data) {
            console.log(data);
            $('#'+ i).siblings().removeClass('hideThis');
            $('#'+ i).addClass('hideThis');
        },
        error: function(data) {alert(data)}
    });

}

// function To delete images from item
function deleteImgs(i) {
    // remove 'deleteImgs' from i first to get pure item id
    var ideleteimages = i.replace('deleteImgs','');
    // get itemid to delete its images
    var deleteitemImages = {item_id : ideleteimages};
    console.log(deleteitemImages.item_id);

    // send the data with ajax
    $.ajax({url: "phpajax/deleteItemImages.php", type: "POST", async: false,
        data: deleteitemImages,
        success: function(data) {
            alert(data);
            // $('#'+ i).siblings().removeClass('hideThis');
            // $('#'+ i).addClass('hideThis');
        },
        error: function(data) {alert(data)}
    });
}


    // refresh images area
    function refreshImagesArea() {
        // get item id 
        let itemid = document.getElementById('itemid').value;
        // set the data we get in var
        var mainData = { 
            itemid : itemid
        };

        var table = '';
        // send it to php file there will get all images
        $.ajax({url: "phpajax/getItemImages.php", type: "POST", async: false,
            data: mainData,
            success: function(data) {
                if (data) {
                    var myJSON = JSON.parse(data);

                    for (let i = 0; i < myJSON.length; i++) {
                        table += `
                                <div class="relative" id="itemid${myJSON[i]['item_ID']}">
                                    <span onclick="deleteSingleRows(this.id);" id="row_id${myJSON[i]['row_id']}">
                                        <i class="fa fa-close"></i> Delete
                                    </span>
                                    <img src="../products/${myJSON[i][1]}">
                                </div>
                                
                            `;   
                    }

                    //document.getElementsByClassName('item-img-container')[0].innerHTML = '';
                    document.getElementsByClassName('item-img-container')[0].innerHTML = table;

                } else if (data == 'noImages') {
                    alert('No Images found for this item');
                    console.log(data);
                }
                
            },
            error: function(data) {alert(data)}
        });       

        // put the data[images] to the imgaes parent div
    }

    // delete image from items.php in set image section
    function deleteSingleRows(i) {

        let row_id = i.replace('row_id','');
        //let itemid = document.getElementById(i).parentElement.getAttribute('id').replace('itemid','');

        // set the data we get in var
        var mainData = { 
            row_id : row_id
        };
       
       
        // send the data with ajax
        $.ajax({url: "phpajax/deleteSingleRow.php", type: "POST", async: false,
            data: mainData,
            success: function(data) {
                if (data == 'success') {
                    console.log('delete ' + data);
                    // this will hide the td after click delete
                    document.getElementById(i).style.display = 'none';
                    document.getElementById(i).parentElement.innerHTML = '<div class="alert alert-info text-capitalize">deleted</div>';
                } else if (data == 'failed') {
                    alert('failed to delete data');
                    console.log(data);
                }
                
            },
            error: function(data) {alert(data)}
        });       
    
    }



    // add new item
    $(".signup_messages").hide();
    $("#add_new_item").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        $.ajax({
            url: "phpajax/upload_item_info.php",
            type: 'POST',
            data: formData,
            beforeSend:function () {
                $("#item_sumbit_button").val("sending item info ...");
            },
            success: function (data) {
                console.log(data);

                if (data == 'success') {
                    window.setTimeout(function(){
                        // Move to a new location or you can do something else
                        window.location.href = "items.php";
                    }, 3000);
                } else {
                    $(".signup_messages").html('failed to insert or update new info for this item maybe you didnt change data in fields');
                }

                $(".signup_messages").show();
                var sign_info_message = '<p class="success_message">' + data + '</p>';
                $(".signup_messages").html(sign_info_message);
                $("#item_sumbit_button").val("Add Item");

            },
            error: function (data) {
                console.log(data);
                var sign_erorr_message = '<p class="error_message">' + data + '</p>';
                $(".signup_messages").fadeIn();
                $(".signup_messages").html(sign_erorr_message);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


// start functions upload items images
    function _(element) {
        return document.getElementById(element);
    }

    // when select images 
    _('gallery-photo-add').onchange = function (event) {

        var form_Data = new FormData();
        var image_number = 1;
        var error = '';

        for (var count = 0; count < _('gallery-photo-add').files.length; count++) {

            if (!['image/jpeg', 'image/png', 'image/jpg', 'image/gif'].includes(_('gallery-photo-add').files[count].type)) {

                error += '<div class="alert alert-danger text-capitalize"><br>'+ image_number +'<br> Selected File must be .jpg or .png only.</div>';

            } else {
                form_Data.append('images[]', _('gallery-photo-add').files[count]);
            }

            image_number++;

        }

        if (error != '') {

            _('uploaded_image').innerHTML = error;
            _('gallery-photo-add').value = '';

        } else {

            _('progress_bar').style.display = 'block';

            // send ajax request
            var ajax_request = new XMLHttpRequest();
            ajax_request.open("POST", "phpajax/upload_item_images.php");

            ajax_request.upload.addEventListener('progress', function(event) {

                var percent_completed = Math.round((event.loaded / event.total) * 100);

                _('progress_bar_process').style.width = percent_completed + '%';
                _('progress_bar_process').innerHTML = percent_completed + '%';

            });

            ajax_request.addEventListener('load', function(event) {

                _('upload_status').innerHTML += '<div class="alert alert-success text-capitalize">files uploaded successfully</div>';
                _('gallery-photo-add').value = '';

            });

            ajax_request.send(form_Data);
        }

    };

// END functions upload items images

    



    

