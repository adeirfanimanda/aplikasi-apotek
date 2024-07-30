<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apotek Rahmayani</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-dashboard.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('auth/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="sign-in-form">
                        @csrf
                        <div class="logo" style="margin-bottom: -100px;">
                            <img src="{{ asset('images/logo-dashboard.png') }}" alt="Apotek Rahmayani" />
                            <h3>Apotek Rahmayani</h3>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="email" name="email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="password" class="input-field" autocomplete="off"
                                    required />
                                <label>Kata Sandi</label>
                            </div>

                            <!-- Display Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>
                                        @foreach ($errors->all() as $error)
                                            {{ rtrim($error, '.') }}<br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <input type="submit" value="Masuk" class="sign-btn" />
                        </div>
                    </form>

                    <form action="index.html" autocomplete="off" class="sign-up-form">
                        <div class="logo">
                            <img src="./img/logo.png" alt="easyclass" />
                            <h4>easyclass</h4>
                        </div>

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>

                            <input type="submit" value="Sign Up" class="sign-btn" />

                            <p class="text">
                                By signing up, I agree to the
                                <a href="#">Terms of Services</a> and
                                <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="{{ asset('auth/img/image1.jpg') }}" class="image img-1 show" alt="" />
                        <img src="{{ asset('auth/img/image2.jpg') }}" class="image img-2" alt="" />
                        <img src="{{ asset('auth/img/image3.jpg') }}" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Kelola Aplikasi Apotek Anda</h2>
                                <h2>Kelola Aplikasi Apotek Anda</h2>
                                <h2>Kelola Aplikasi Apotek Anda</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Javascript file -->
    <script src="{{ asset('auth/app.js') }}"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
