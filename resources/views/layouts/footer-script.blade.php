        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/toastr/toastr.min.js') }}"></script>

        @yield('script')
        <!-- App js -->
        <script src="{{ URL::asset('assets/js/app.min.js') }}"></script>
        <script>
            @if (Session::has('success'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.success("{{ session('success') }}");
            @endif
            @if (Session::has('error'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.error("{{ session('error') }}");
            @endif
            @if (Sentinel::getUser())
                function notifyCount(){
                var load_count = $('.badge-pill').html();
                var token = $("input[name='_token']").val();
                $.ajax({
                type: "get",
                url: "/notification-count",
                data:{
                _token: token,
                },
                success: function (data) {
                $('.badge-pill').html(data);
                if(load_count < data){ notificationShow(); } }, error:function (data){ console.log(data); } }); }
                    setInterval(function() { notifyCount(); }, 10000); @endif
            @if (Sentinel::getUser())
                function notificationShow(){
                var token = $("input[name='_token']").val();
                $.ajax({
                type: "POST",
                url: "/top-notification",
                data:{
                _token: token,
                },
                success: function (data) {
                $('.notification-list-scroll').html(data.options);
                },
                error:function (data){
                console.log(data);
                }
                });
                }
                setInterval(function() {
                notificationShow();
                }, 5000);
            @endif
        </script>
        @yield('script-bottom')
