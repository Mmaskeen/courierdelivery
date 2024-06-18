

<!-- Dashboard Core -->
<script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/selectize.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/circle-progress.min.js')}}"></script>
<script src="{{asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>

<!--Select2 js -->
<script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>

<!-- Timepicker js -->
<script src="{{asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
<script src="{{asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

<!-- Datepicker js -->
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
{{--<script src="{{asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>--}}
<!--Horizontal-menu Js-->
<script src="{{asset('assets/plugins/horizontal-menu/webslidemenu.js')}}"></script>

<!-- Charts Plugin -->
<script src="{{asset('assets/plugins/echarts/echarts.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>


<!-- Custom scroll bar Js-->
<script src="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Index Scripts -->
<script src="{{asset('assets/js/index4.js')}}"></script>
<script src="{{asset('assets/js/charts.js')}}"></script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>




<!--Morris.js Charts Plugin -->
<script src="{{asset('assets/plugins/morris/raphael-min.js')}}"></script>
<script src="{{asset('assets/plugins/morris/morris.js')}}"></script>

<!-- Search Js-->
<script src="{{asset('assets/js/prefixfree.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom-->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- Inline js -->
<script src="{{asset('assets/js/select2.js')}}"></script>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('d30655e85adcf11df71f', {
        cluster: 'us3'
    });

    var channel = pusher.subscribe('newOrderNotification');

    channel.bind('pusher:subscription_succeeded', function() {
        console.log(' Yipee!!');
    });

    channel.bind('pusher:subscription_error', function() {
        console.log('Oh nooooos!');
    });

    pusher.connection.bind('state_change', function(states) {
        var prevState = states.previous;
        var currState = states.current;
    });

    var currentState = pusher.connection.state;

    console.log(currentState);
    channel.bind('newOrderEvent', function(data) {
        var audio = new Audio('https://notificationsounds.com/soundfiles/08b255a5d42b89b0585260b6f2360bdd/file-sounds-1137-eventually.wav');
        audio.play();


        var element = ' <a href="{{auth()->user()->getNewOrderUrl().'/'}}'+data.data['id']+' " class="dropdown-item d-flex pb-3 bg-lime-light">\n' +
            '                                        <div class="notifyimg">\n' +
            '                                            <i class="fa fa-thumbs-o-up"></i>\n' +
            '                                        </div>\n' +
            '                                        <div>\n' +
            '                                            <strong>You have a new order.</strong>\n' +
            '                                            <div class="small text-muted">'+data.data['formatted_created_at']+'</div>\n' +
            '                                        </div>\n' +
            '                                    </a>'
        $('.nav-unread').removeClass('hide');
        $('.notificationsList').prepend(element);

    });


</script>
</body>
</html>
