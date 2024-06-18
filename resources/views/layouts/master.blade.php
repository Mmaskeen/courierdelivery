@include('layouts.header')
@yield('body')

@include('layouts.footer')
@include('layouts.js')
@yield('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click','#notification-dropdown .mdi-bell-outline',function () {
            console.log('in');
           let url = '{{route('read_notification')}}';
           $.get(url,function (response) {
                if(response === 'success'){
                    $('.nav-unread').addClass('hide');
                }
           });
        });
        $(document).on('click','.sorting-orders',function (e) {
           let url = "{{route('admin_sorting_order')}}";
            let type = $(this).attr('data-type');
            let column = $(this).attr('data-column');
            let status = "{{request('statusFilter')}}";
            let city = "{{request('cityFilter')}}";
            let fromDate = "{{request('fromDate')}}";
            let toDate = "{{request('toDate')}}";
            let page = "{{request('page')}}";
            let data = {
                '_token' : "{{csrf_token()}}",
                'type' : type,
                'column' : column,
                'cityFilter' : city,
                'statusFilter' : status,
                'fromDate' : fromDate,
                'toDate' : toDate,
                'page' : page,
            }
            $.get(url,data,function (response) {
                if(response.status == 'success'){
                    $('#mainTableBody').empty();
                    $('#mainTableBody').html(response.view);
                }

            });
        });
        $(".checkall").change(function() {
            if (this.checked) {
                $(".checkboxes").each(function() {
                    this.checked=true;
                });

            } else {
                $(".checkboxes").each(function() {
                    this.checked=false;
                });
            }
            var count = $("input[name = 'orderCheck']:checked").length;

            $('#totalSelected').empty().append('('+count+')');
            console.log(count);
        });
        $(".checkboxes").click(function () {
            if ($(this).is(":checked")) {
                var isAllChecked = 0;

                $(".checkboxes").each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                });

                if (isAllChecked == 0) {
                    $(".checkall").prop("checked", true);
                }
            }
            else {
                $(".checkall").prop("checked", false);
            }

            var count = $("input[name = 'orderCheck']:checked").length;

            $('#totalSelected').empty().append('('+count+')');
            console.log(count);

        });
        $(document).on('click',".order_status",function (e) {
            $(".at-viewstatuscontent").empty();
            e.preventDefault();
            var id = $(this).data('id');
            $(".at-viewstatusholder").empty().append('<div class="at-viewstatushead">\n' +
                '                        <span>Name</span>\n' +
                '                        <span>Status</span>\n' +
                '                        <span>Date/Time</span>\n' +
                '                    </div>');
            $.ajax({
                method:"GET",
                url:"/admin/order/view-order-status/"+id,
                success:function(response) {
                    $.each(response, function (key,value) {
                        var date = new Date(value.pivot.created_at)
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'pm' : 'am';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // the hour '0' should be '12'
                        minutes = minutes < 10 ? '0'+minutes : minutes;
                        var Time = hours + ':' + minutes + ' ' + ampm;
                        $(".at-viewstatusholder").append('<ul class="at-viewstatuscontent">\n' +
                            '                        <li>\n' +
                            '                            <h2>'+value.name+'</h2>\n' +
                            '                        </li>\n' +
                            '                        <li>\n' +
                            '                            <em class="at-statuspreview badge-'+value.pivot.order_status+'">'+value.pivot.order_status+'</em>\n' +
                            '                        </li>\n' +
                            '                        <li>\n' +
                            '                            <h2>'+date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear()+' / '+ Time+'</h2>\n' +
                            '                        </li>\n' +
                            '                    </ul>')
                    })
                }
            })
        })

    });

    @if(\Illuminate\Support\Facades\Session::has('success'))
    toastr.success("{{Session::get('success')}}", 'Success',{timeOut: 3000});

    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
    toastr.error('{{Session::get('error')}}', 'error',{timeOut: 3000});

    @endif
</script>
