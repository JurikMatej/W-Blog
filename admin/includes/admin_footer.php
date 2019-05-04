</div>
    <!-- /#wrapper -->

    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

<!-- Toastr.min.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Pusher CDN -->
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('6266735b11d773698211', {
    cluster: 'eu',
    forceTLS: true
});

var channel = pusher.subscribe('notifications');
channel.bind('new user', function(data) {
    // console.log(data.message);
    toastr.success(`${data.message} Just Registered !`);

});
</script>