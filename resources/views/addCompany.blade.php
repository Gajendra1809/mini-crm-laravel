<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniCRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
       .formstyle {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .formstyle label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .formstyle input[type="text"],
    .formstyle input[type="email"],
    .formstyle input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .formstyle input[type="file"] {
        padding: 8px;
    }

    .formstyle button[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .formstyle button[type="submit"]:hover {
        background-color: #45a049;
    }

    .error {
        color: red;
        margin-top: -5px;
    }
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            width: 50%;
            max-width: 400px;
            /* Set maximum width */
            animation: slideInOut 0.6s forwards;
        }

        .msgpopup {
            position: fixed;
            top: 0;
            left: 80%;
            transform: translateX(-30%);
            z-index: 9999;
            width: 20%;
            max-width: 400px;
            /* Set maximum width */
            animation: slideInOut2 0.6s forwards;
        }
*
         @keyframes slideInOut {
0% {
    top: -100%;
}
100% {
    top: 20%;
}
}
@keyframes slideInOut2 {
0% {
    top: -100%;
}
100% {
    top: 10%;
}
}
    </style>
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
                    <a class="nav-link" style="margin-left:-15px" href="{{ route("company.create") }}">Add Company</a>
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

    <h4 style="margin-left:50px">Add Company details :-</b></h5><br><br><br>
        <form class="formstyle container" action="{{ route('company.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}"><br>
            @if($errors->has('name'))
                <p class="error">*{{ $errors->first('name') }}</p>
            @endif
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="{{ old('email') }}"><br>
            @if($errors->has('email'))
                <p class="error">*{{ $errors->first('email') }}</p>
            @endif
            <label for="logo">Logo:</label>
            <input type="file" id="logo" name="logo" required value="{{ old('logo') }}"><br>
            @if($errors->has('logo'))
                <p class="error">*{{ $errors->first('logo') }}</p>
            @endif
            <label for="website">Website:</label>
            <input type="text" id="website" name="website" required value="{{ old('website') }}"><br>
            @if($errors->has('website'))
                <p class="error">*{{ $errors->first('website') }}</p>
            @endif

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
            </div>

        </form>
</body>

</html>
