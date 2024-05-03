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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>\
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        .formstyle input {
            width: 70%;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .formstyle button {
            width: 100%;
            padding: 10px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
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
        .error{
            color: red;
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
                    <a class="nav-link" href="{{ route("landing") }}">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("company.index") }}">Company Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('employee.index') }}">Employee Dashboard</a>
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

    <h4 style="margin-left:50px">Add Employee details :-</b></h5><br><br><br>

        <form id="popup-form" class="formstyle container" action="{{ route('employee.store') }}"
            method="POST">
            @csrf
            First Name: <input type="text" name="fname" id="fname" value="{{ old('fname') }}"><br>
            @if($errors->has('fname'))
                <p class="error">*{{ $errors->first('fname') }}</p>
            @endif
            Last Name: <input type="text" name="lname" id="lname" value="{{ old('lname') }}"><br>
            @if($errors->has('lname'))
                <p class="error">*{{ $errors->first('lname') }}</p>
            @endif
            Email: <input type="email" name="email" id="email" value="{{ old('email') }}"><br>
            @if($errors->has('email'))
                <p class="error">*{{ $errors->first('email') }}</p>
            @endif
            Phone: <input type="text" name="phone" id="phone" value="{{ old('phone') }}"><br>
            @if($errors->has('phone'))
                <p class="error">*{{ $errors->first('phone') }}</p>
            @endif
            Company:
            <select class="js-example-basic-single" name="company_id" >
                <option value=""></option>
                @foreach($company as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>


            @if($errors->has('company_id'))
                <p class="error">*{{ $errors->first('company_id') }}</p>
            @endif
            <br><br><br>

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
            </div>

        </form>
        <script>
            $(document).ready(function () {
                $('.js-example-basic-single').select2();
            });

        </script>
</body>

</html>
