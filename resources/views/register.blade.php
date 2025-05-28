<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/favicon.jpg') }}" alt="Logo Polisi App" style="height: 40px;">
                                </a>
                                <p class="text-center mb-1">Police App</p>
                                <p class="text-center mt-0">Connecting Citizens with Law Enforcement</p>
                                <form id="registerForm">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Masukkan nama Anda">
                                        <small id="nameError" class="text-danger"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Alamat Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Masukkan email aktif">
                                        <small id="emailError" class="text-danger"></small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Kata Sandi</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Buat kata sandi">
                                        <small id="passwordError" class="text-danger"></small>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded-2">Register</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-5 mb-0">Sudah punya akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="/">Sign In</a>
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
    <script src="{{ asset('js/register.js') }}"></script>

</body>

</html>
