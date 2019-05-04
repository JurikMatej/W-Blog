$(document).ready(function () {
    // Admin -> view_all_posts.php -> checkbox functionality
    $('#selectAllBoxes').click(function() {
        if (this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true; 
            });
        } else {
            $('.checkBoxes').each(function() {
                this.checked = false;
            });
        }
    });


    // Admin -> All -> loader gif
    const div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $('body').prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function () { 
        $(this).remove();
    });



});

function loadUsersOnline() {

    $.get(
        "functions.php?onlineusers=result", 
        function(data) {
            $('.usersonline').text(data);
        }
    );

}

setInterval(loadUsersOnline, 1000);