$(document).ready(function () {
    toastr.options = {
        "positionClass": "toast-top-left",
        "closeButton": true,
        "progressBar": true,
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    function checkNotifications() {
        $.ajax({
            url: 'pages/fetch_notifications.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.upcoming_goals > 1) {
                    toastr.warning('Имаш ' + response.upcoming_goals + ' предстоящи цели!');
                } else if (response.upcoming_goals == 1) {
                    toastr.warning('Имаш 1 предстояща цел!');
                }

                if (response.upcoming_obligations > 1) {
                    toastr.error('Имаш ' + response.upcoming_obligations + ' задължения, които наближават!');
                } else if (response.upcoming_obligations == 1) {
                    toastr.error('Имаш 1 задължение, което наближава!');
                }
            }
        });
    }

    checkNotifications();
    setInterval(checkNotifications, 120000);
});