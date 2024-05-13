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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/addEmp.css') }}">
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
                            href="{{ route("employee.create") }}">Add Employee</a>
                    </div>
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

    <!-- This is Add Employee details form -->
    <h4 style="margin-left:50px">Add Employee details :-</b></h5><br><br><br>

        <form id="popup-form" class="formstyle container" action="{{ route('employee.store') }}"
            method="POST">
            @csrf
            <label for="company_id"><b> Company:</b></label>
            <select class="js-example-basic-single" name="company_id" id="companyId">
                <option
                    value="{{ request('id')?request('id'):'' }}">
                    {{ $companyData?$companyData->name:'' }}</option>
                @foreach($company as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
            <span id="companyError" class="error"></span><br>
            @if($errors->has('company_id'))
                <p class="error">*{{ $errors->first('company_id') }}</p>
            @endif
            <br>
            <label for="fname"><b> First Name:</b></label>
            <input type="text" name="fname" id="fname" required value="{{ old('fname') }}">
            <span id="fnameError" class="error"></span><br>
            @if($errors->has('fname'))
                <p class="error">*{{ $errors->first('fname') }}</p>
            @endif

            <label for="lname"><b> Last Name:</b></label>
            <input type="text" name="lname" id="lname" required value="{{ old('lname') }}">
            <span id="lnameError" class="error"></span><br>
            @if($errors->has('lname'))
                <p class="error">*{{ $errors->first('lname') }}</p>
            @endif

            <label for="email"><b> Email:</b></label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
            <span id="emailError" class="error"></span><br>
            @if($errors->has('email'))
                <p class="error">*{{ $errors->first('email') }}</p>
            @endif

            <label for="phone"><b> Phone:</b></label>
            <input type="text" name="phone" id="phone" required value="{{ old('phone') }}">
            <span id="phoneError" class="error"></span><br>
            @if($errors->has('phone'))
                <p class="error">*{{ $errors->first('phone') }}</p>
            @endif

            <div style="display:flex;justify-content: center;margin-top: 20px;">
                <button id="submitBtn" type="submit">Submit</button>
            </div>
        </form><br><br><br><br>

        <!-- This is footer -->
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
        
        <script src="{{asset('js/addEmployee.js')}}"></script>
</body>

</html>
