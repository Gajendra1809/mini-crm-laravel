<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniCRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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

        @keyframes slideInOut {
0% {
    top: -100%;
}
100% {
    top: 20%;
}
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
            max-width: 400px;
            /* Set maximum width */
            animation: slideInOut2 0.6s forwards;
        }
        .error{
            color:red; class="error"
*        }


        @keyframes slideInOut2 {
0% {
    top: -100%;
}
100% {
    top: 10%;
}
}

        /* Styling for the form */

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
    <h4 style="margin-left:50px">Here are the Employee of :- {{ $company->name }}</b></h5><br><br><br>

        <form id="deleteform" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        <div class="container">

            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="popup-container" id="birthdayForm">
            <form id="popup-form" class="formstyle" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                <div style="display:flex;gap: 3px">
                    <button type="submit" style="background-color: green;">Submit</button>
                    <button type="button" onclick="window.location.reload()"
                        style="background-color: red;">Cancel</button>
                </div>

            </form>
        </div>


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
            ajax: "{{ route('employee.index',['id' => $company->id]) }}",
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

    //Pop form to add bithday
    openform();

    function openform(e) {
        var form = document.getElementById("birthdayForm");
        if (form.style.display === "none") {
            form.style.display = "block";
            console.log(e.id);
            if (e) {
                // If `c` is provided, populate the form fields with its data
                document.getElementById("fname").value = e.fname;
                document.getElementById("lname").value = e.lname;
                document.getElementById("email").value = e.email;
                document.getElementById("phone").value = e.phone;
                // Set the action attribute of the form
                document.getElementById("popup-form").action =
                    "{{ route('employee.update', '') }}/" + e.id;
                location.Storage.setItem('id', e.id);
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
            "{{ route('employee.update', '') }}/" + location.Storage.getItem(
                'id');
    }

</script>

</html>
