

// Start read
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
