@extends('../layout/' . 'auth')

@section('head')
    <title>Verify Email - @appName</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="@appName logo" class="w-28" src="{{ asset('build/assets/images/stack-logo.png') }}">
                    {{--<span class="text-white text-lg ml-3">
                        @appName
                    </span>--}}
                </a>
                <div class="my-auto">
                    <img alt="illustration" class="-intro-x w-1/2 -mt-16" src="{{ asset('build/assets/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Before we sign you in, <br /> could you verify your email?</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">If you didn't receive any mail, resend it and we will gladly send you another.</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                    <!-- BEGIN: Session msg -->
                    <div class="mb-5">
                        <x-session-msg />
                    </div>
                    <!-- BEGIN: Session msg -->

                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Verify Email</h2>
                    <div class="intro-x mt-2 text-slate-400 text-center xl:text-left">Before we sign you in, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, please resend it and we will gladly send you another.</div>
                    <div class="intro-x mt-8">
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <form id="auth-form" method="post" class="inline" action="{{ route('verification.send') }}">
                                @csrf

                                    <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-56 xl:mr-3 align-top">Resend Verification Email</button>
                            </form>

                            <form action="{{ route('logout') }}" method="post" class="inline" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                >
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection
