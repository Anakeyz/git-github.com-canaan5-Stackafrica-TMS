@extends('../layout/' . 'auth')

@section('head')
    <title>Forgot Password - @appName</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="@appName logo" class="w-28" src="{{ asset('build/assets/images/stack-logo.png') }}">
                </a>
                <div class="my-auto">
                    <img alt="illustration" class="-intro-x w-1/2 -mt-16" src="{{ asset('build/assets/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Forgot your password? <br /> That's okay, it happens.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Enter your email to reset your password.</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Forgot Password?</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">That's okay, it happens. Enter your email to reset your password.</div>
                    <div class="intro-x mt-8">
                        <form id="auth-form" method="post" action="{{ route('password.email') }}">
                            @csrf
                            <input id="email" type="text" name="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email">
                            <x-input-error input-name="email" />

                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection
