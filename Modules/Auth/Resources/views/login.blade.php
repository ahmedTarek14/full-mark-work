<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Full Mark Work</title>
    <link rel="shortcut icon" type="image/png" href="{{ aurl('images/logos/loogoo.png') }}" />
    <link rel="stylesheet" href="{{ aurl('css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ aurl('images/logos/loogoo.png') }}" width="180" alt="">
                                </a>
                                <p class="text-center">Sign in To Your Account</p>
                                <form method="post" action="{{ route('admin.login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" name="name">
                                        @error('name')
                                            <div id="error-name" class="login__input-error text-danger mt-2">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1">
                                        @error('password')
                                            <div id="error-password" class="login__input-error text-danger mt-2">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ aurl('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ aurl('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
