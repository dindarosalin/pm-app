<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Masuk</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="Abarobotics">
    <meta name="description" content="Abarobotics">
    <meta name="application-name" content="Abarobotics">
    <meta name="generator" content="Ports Abarobotics">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="Abarobotics">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Abarobotics">
    <meta property="og:image" content="{{ asset('favicon.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('favicon.png') }}">
    <meta http-equiv="refresh" content="120">
    <link href="{{ asset('favicon.png') }}" rel="icon">
    <link href="{{ asset('favicon.png') }}" rel="icon">
    @include('include.css')
    <!-- jQuery -->
    <script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>

    <script type="text/javascript">
        document.onkeydown = function(e) {
            if (event.keyCode == 123) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
        }
    </script>
    {{-- {!! RecaptchaV3::initJs() !!} --}}

</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div>
        @if (session('danger'))
        <div style="width: 22rem;">
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        </div>
        @endif

        <div class="card" style="width: 22rem;">
            <div class="card-body px-4">
                <!-- Logo -->
                <div class="app-brand text-center mt-4">
                    <a href="{{ url('/') }}" class="app-brand-link d-flex justify-content-center"
                        style="max-width: 60%;">
                        <img src="https://abarobotics.com/front/assets/img/logo-automation-company.jpg" alt="logo"
                            class="img-fluid">
                    </a>
                </div>
                <br>

                <form id="formAuthentication" action="{{ url('/login/process') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-2 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label for="password">Kata Sandi</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" class="form-control form-control-sm" minlength="8"
                                maxlength="20" required />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <a href="{{ url('/lupa-password') }}">
                            <small>Lupa Kata Sandi?</small>
                        </a>
                    </div>

                    <div class="mb-3">
                        {{-- {!! RecaptchaV3::field('register') !!} --}}
                    </div>
                    <br>
                    <div class="mb-3">
                        <button class="btn btn-success btn-sm d-grid w-100" type="submit">Masuk</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>

    @include('include.js')
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Auto close alert -->
    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $('.alert-auto-close').fadeOut('slow').addClass('d-none');
            }, 5000);
        });

        console.log("%c Hey what are you looking for? 🤖 looking for job vacancies, look at {{ url('/career') }} ",
            "background:#008037;color:#ffffff;font-family:Lucida console;font-size:12px;letter-spacing:-1px;display:block;padding:5px;box-shadow: 0 1px 0 rgba(255, 255, 255, 0.4) inset, 0 5px 3px -5px rgba(0, 0, 0, 0.5), 0 -13px 5px -10px rgba(255,255,255,0.4) inset"
        );
    </script>
</body>


</html>
