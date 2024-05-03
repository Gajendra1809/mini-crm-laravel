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
    <!-- <link rel="stylesheet" href="{{ asset('css/home.css') }}"> -->
    <style>
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
        .popup-container2 {
position: fixed;
top: 0;
left: 80%;
transform: translateX(-30%);
background-color: green;
padding: 10px;
border: 1px solid #ccc;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
z-index: 9999;
width: 20%;
max-width: 400px; /* Set maximum width */
animation: slideInOut2 0.6s forwards;
}

        @keyframes slideInOut {
0% {
    top: -100%;
}
100% {
    top: 20%;
}
}
.formstyle input,select {
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

            </ul>

        </div>
        <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>
        <!-- This is to handle messages sent through session -->
        @if(session()->has('success'))
        <h5 class="popup-container2">
            {{ session('success') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👍</h5>
    @endif
    @if(session()->has('error'))
        <h5 class="popup-container2">
            {{ session('error') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    @endif

    <div style="display: flex;justify-content: center;align-items: center;margin-left: 150px;margin-top: 100px;">
    <div class="row mx-auto">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Company Manipulation</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="{{route('company.create')}}" class="btn btn-primary btn-sm">Add Company</a>
                    <a href="{{route('company.index')}}" class="btn btn-primary btn-sm">Company Dashboard</a>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employee Manipulation</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="{{route('employee.create')}}" class="btn btn-primary btn-sm">Add Employee</a>
                    <a href="{{route('employee.index')}}" class="btn btn-primary btn-sm">Employee Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="popup-container" id="addcomform">
        <form id="popup-form" class="formstyle" action="{{ route('company.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="logo">Logo:</label>
            <input type="file" id="logo" name="logo" required><br>
            <label for="website">Website:</label>
            <input type="text" id="website" name="website" required><br>
           
            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
                <button type="button" onclick="opencompanyform()" style="background-color: red;">Cancel</button>
            </div>

        </form>
    </div>


    <div class="popup-container" id="addempform">
        <form id="popup-form" class="formstyle" action="{{route('employee.store')}}" method="POST" >
            @csrf
            First Name: <input type="text" name="fname" id="fname"><br>
            Last Name: <input type="text" name="lname" id="lname"><br>
            Email: <input type="email" name="email" id="email"><br>
            Phone: <input type="text" name="phone" id="phone"><br>
            Company: 
    <select name="company_id" id="">
        <option value=""></option>
        @foreach ($companies as $c)
            <option value="{{$c->id}}">{{$c->name}}</option>
        @endforeach
    </select><br><br><br>

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
                <button type="button" onclick="openempform()" style="background-color: red;">Cancel</button>
            </div>

        </form>
    </div>


    <script>
        //Pop form to add bithday
        opencompanyform();

        function opencompanyform() {
            var form = document.getElementById("addcomform");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }

        openempform();

        function openempform() {
            var form = document.getElementById("addempform");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

</body>

</html>
