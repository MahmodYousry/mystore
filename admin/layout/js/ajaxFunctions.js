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