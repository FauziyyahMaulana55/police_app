<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/favicon.jpg') }}" alt="Police App Logo"
                                        style="height: 40px;">
                                </a>
                                <p class="text-center mb-1">Police App</p>
                                <p class="text-center mt-0">Connecting Citizens with Law Enforcement</p>
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            aria-describedby="emailHelp">
                                        <small id="emailError" class="text-danger"></small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password">
                                        <small id="passwordError" class="text-danger"></small>
                                    </div>

                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" id="loginBtn">Sign
                                        In</button>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">New to Police App?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ url('register') }}">Create an
                                            account</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
