@extends('../layout/base')

@section('body')
    <body class="login">
        @yield('content')
        {{--@include('../layout/components/dark-mode-switcher')
        @include('../layout/components/main-color-switcher')--}}

        <!-- BEGIN: Session msg -->
        <x-session-msg />
        <!-- BEGIN: Session msg -->

        <!-- BEGIN: JS Assets-->
        @vite('resources/js/app.js')
        <!-- END: JS Assets-->

        @yield('script')
{{--        for auth views--}}
        <script type="module">
            (function () {

                let authForm = $('#auth-form');
                let authBtn = $('#auth-btn');

                async function login() {
                    // Loading state
                    authBtn.html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>')
                    tailwind.svgLoader()
                    await helper.delay(1500)
                }

                authBtn.on('click', function() {
                    login()
                })
            })()
        </script>
    </body>
@endsection
