<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniCRM</title>
    <link rel="icon" href="{{asset('logos/crmlogo.png')}}" type="image/icon type">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/addComp.css') }}">
</head>

<body>
    <!-- This is Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <h2><a class="navbar-brand p-2 " href="#">MiniCRM</a></h2>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <div style="display:flex">
                        <a class="nav-link" href="{{ route("landing") }}">Home/</a>
                        <a class="nav-link" style="margin-left:-15px"
                            href="{{ route("company.create") }}">Add Company</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("company.index") }}">Company Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("employee.index") }}">Employee Dashboard</a>
                </li>

            </ul>

        </div>
        <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>

    <!-- This is to handle messages sent through session -->
    @if(session()->has('success'))
        <div class="alert alert-success msgpopup">
            <strong>Success!</strong> {{ session('success') }}👍
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger msgpopup">
            <strong>Something went wrong!</strong> {{ session('error') }}
        </div>
    @endif

    <!-- Add Company details form -->
    <h4 style="margin-left:50px">Add Company details :-</b></h5><br><br><br>
        <form class="formstyle container" action="{{ route('company.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <label for="name">Name*:</label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}"><br>
            <span id="nameError" class="error"></span>
            @if($errors->has('name'))
                <p class="error">*{{ $errors->first('name') }}</p>
            @endif
            <label for="email">Email*:</label>
            <input type="email" id="email" name="email" required value="{{ old('email') }}"><br>
            <span id="emailError" class="error"></span>
            @if($errors->has('email'))
                <p class="error">*{{ $errors->first('email') }}</p>
            @endif
            <label for="logo">Logo*:</label>
            <input type="file" id="logo" name="logo" required value="{{ old('logo') }}"><br>
            <span id="logoError" class="error"></span>
            @if($errors->has('logo'))
                <p class="error">*{{ $errors->first('logo') }}</p>
            @endif
            <label for="website">Website*:</label>
            <input type="text" id="website" name="website" required value="{{ old('website') }}"><br>
            <span id="websiteError" class="error"></span>
            @if($errors->has('website'))
                <p class="error">*{{ $errors->first('website') }}</p>
            @endif
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="{{ old('location') }}"><br>
            <span id="locationError" class="error"></span>
            @if($errors->has('location'))
                <p class="error">*{{ $errors->first('location') }}</p>
            @endif

            <div style="display:flex;gap: 3px">
                <button id="submitBtn" type="submit" style="background-color: green;">Submit</button>
            </div>

        </form><br><br><br><br>

        <!-- This is Footer -->
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
            </ul>
            <p class="text-center text-body-secondary">© 2024 Company, Inc</p>
        </footer>

        <script src="{{asset('js/addCompany.js')}}"></script>
</body>

</html>
