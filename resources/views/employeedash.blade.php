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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/empDash.css') }}">
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
                            href="{{ route("employee.index") }}">Employee Dashboard </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("company.index") }}">Company Dashboard</a>
                </li>
                <li>
                    <a href="{{ route("employee.create") }}"
                        class="btn btn-outline-success my-2 my-sm-0">Add Employee</a>
                </li>

            </ul>

        </div>
        <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>

    <div style="display:flex">
        <h4 style="margin-left:50px">Employee Dashboard:- </h4>
        <a style="margin-left:940px" class="btn btn-primary btn-sm" href="{{ route('employee.export') }}">Download Employees data in CSV file <i class="fa-solid fa-download"></i> </a>
    </div><br><br><br>

    <!-- Display erro or success messages if any -->
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


    <form id="deleteform" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Table to show employee listing using Yahra datatables -->
    <div class="container">
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- This is popup form editing employee details -->
    <div class="popup-container" id="birthdayForm">
        <form id="popup-form" class="formstyle" action="" method="POST">
            @csrf
            @method('PUT')
            <h5>Employee Edit form :-</h5><br>
            <b>First Name:</b> <input type="text" name="fname" id="fname" value="{{ old('fname') }}"><br>
            <span id="fnameError" class="error marginleft"></span>
            @if($errors->has('fname'))
                <p class="error marginleft">*{{ $errors->first('fname') }}</p>
            @endif
            <br>
            <b>Last Name:</b> <input type="text" name="lname" id="lname" value="{{ old('lname') }}"><br>
            <span id="lnameError" class="error marginleft"></span>
            @if($errors->has('lname'))
                <p class="error marginleft">*{{ $errors->first('lname') }}</p>
            @endif
            <br>
            <b>Email:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" name="email" id="email" value="{{ old('email') }}"><br>
            <span id="emailError" class="error marginleft"></span>
            @if($errors->has('email'))
                <p class="error marginleft">*{{ $errors->first('email') }}</p>
            @endif
            <br>
            <b>Phone:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone" id="phone" value="{{ old('phone') }}"><br>
            <span id="phoneError" class="error marginleft"></span>
            @if($errors->has('phone'))
                <p class="error marginleft">*{{ $errors->first('phone') }}</p>
            @endif
            <br>
            <div style="display:flex;gap: 3px">
                <button id="saveBtn" type="submit" style="background-color: green;">Save</button>
                <button type="button" onclick="window.location.reload()" style="background-color: red;">Cancel</button>
            </div>

        </form>
    </div><br><br><br><br>

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


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'fname',
                    name: 'fname'
                },
                {
                    data: 'lname',
                    name: 'lname'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

    });

    function deletefun(id) {
        console.log(id);
        if (confirm('Are you sure you want to remove this Employee?')) {
            event.preventDefault();
            form = document.getElementById('deleteform');
            form.action = "{{ route('employee.destroy', '') }}/" + id;
            form.submit();
        }
    }

    //Pop form
    openform();
    function openform(e) {
        var form = document.getElementById("birthdayForm");
        if (form.style.display === "none") {
            form.style.display = "block";
            //console.log(e.id);
            if (e) {
                document.getElementById("fname").value = e.fname;
                document.getElementById("lname").value = e.lname;
                document.getElementById("email").value = e.email;
                document.getElementById("phone").value = e.phone;
                // Set the action attribute of the form
                document.getElementById("popup-form").action =
                    "{{ route('employee.update', '') }}/" + e.id;
                localStorage.setItem('eid', e.id);
            }
        } else {
            form.style.display = "none";
            // If the form is closed, reset the form fields and action attribute
            document.getElementById("popup-form").reset();
            document.getElementById("popup-form").action = "";
        }
    }
    if ("{{ $errors->has('fname') }}" || "{{ $errors->has('email') }}" ||
        "{{ $errors->has('lname') }}" || "{{ $errors->has('phone') }}") {
        openform();
        document.getElementById("popup-form").action =
            "{{ route('employee.update', '') }}/" + localStorage.getItem(
                'eid');
    }

    //edit form vlidations
    document.addEventListener('DOMContentLoaded', function() {
const fnameField = document.getElementById('fname');
const lnameField = document.getElementById('lname');
const emailField = document.getElementById('email');
const phoneField = document.getElementById('phone');
const submitBtn = document.getElementById('saveBtn');

fnameField.addEventListener('input', validateForm);
lnameField.addEventListener('input', validateForm);
emailField.addEventListener('input', validateForm);
phoneField.addEventListener('input', validateForm);

function validateForm() {
let fnameValid = fnameField.value.trim() !== '';
let lnameValid = lnameField.value.trim() !== '';
let emailValid = isValidEmail(emailField.value);
let phoneValid = phoneField.value.trim().length >= 10;

const fnameError = document.getElementById('fnameError');
const lnameError = document.getElementById('lnameError');
const emailError = document.getElementById('emailError');
const phoneError = document.getElementById('phoneError');

fnameError.textContent = fnameValid ? '' : '*First Name is required';
lnameError.textContent = lnameValid ? '' : '*Last Name is required';
emailError.textContent = emailValid ? '' : '*Please enter a valid email address';
phoneError.textContent = phoneValid ? '' : '*Phone number must be at least 10 characters';

if (fnameValid && lnameValid && emailValid && phoneValid) {
    submitBtn.style.display ="block";
} else {
    submitBtn.style.display ="none";
}
}

function isValidEmail(email) {
return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
});

</script>

</html>
