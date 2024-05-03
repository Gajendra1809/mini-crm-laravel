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
            max-width: 400px;
            /* Set maximum width */
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
                    <a class="nav-link" href="{{route("employee.index")}}">Employee Dashboard</a>
                </li>
                <li>
                    <a href="{{route("company.create")}}" class="btn btn-outline-success my-2 my-sm-0">Add Company</a>
                </li>&nbsp;&nbsp;
                <li>
                    <a href="{{route("employee.create")}}" class="btn btn-outline-success my-2 my-sm-0">Add Employee</a>
                </li>

            </ul>

        </div>
        <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>
    <h4 style="margin-left:50px">Company Dashboard:- </h4><br><br><br>
    <!-- This is to handle messages sent through session -->
    @if(session()->has('success'))
        <h5 class="popup-container2">
            {{ session('success') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👍</h5>
    @endif
    @if(session()->has('error'))
        <h5 class="popup-container2">
            {{ session('error') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    @endif
    @if($company->isEmpty())
            <h4>No Companies found!</h4>
        @endif     
   
    <table class="table container table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Logo</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Website</th>
                <th scope="col">Employees</th>
            </tr>
            
        </thead>
        <tbody>
           @foreach($company as $c)
            <tr>
                <td><img src="{{ $c->logo }}" alt="logo" style="width:50px;border-radius: 20px;"></td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->email }}</td>
                <td><a href="{{ $c->website }}">{{ $c->website }}</a></td>
                <td><a href="{{ route('employee.index',['id' => $c->id]) }}">Get employees</a></td>
                <td><button onclick="openeditform({{ json_encode($c) }})" class="btn btn-primary btn-sm">Edit</button></td>
            <td><form id="delete-form-{{ $c->id }}"
                action="{{ route('company.destroy', $c->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form><a href="#" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this company?')) { event.preventDefault(); document.getElementById('delete-form-{{ $c->id }}').submit(); }">Delete</a></td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
 

    <div class="popup-container" id="editform">
        <form id="popup-form2" class="formstyle" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            Name: <input type="text" name="name" id="edit-name" ><br>
            @if ($errors->has('name'))
                <p>{{$errors->first('name')}}</p>
            @endif
            Email: <input type="email" name="email" id="edit-email"><br>
            @if ($errors->has('email'))
                <p>{{$errors->first('email')}}</p>
            @endif
            logo: <input type="file" name="logo" id="edit-logo"><br>
            @if ($errors->has('logo'))
                <p>{{$errors->first('logo')}}</p>
            @endif
            Website: <input type="text" name="website" id="edit-website" ><br>
            @if ($errors->has('website'))
                <p>{{$errors->first('website')}}</p>
            @endif

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
                <button type="button" onclick="openeditform()" style="background-color: red;">Cancel</button>
            </div>


        </form>
    </div>


    <script>
        //Popup form to edit companies
        openeditform();

        function openeditform(c) {
            var form = document.getElementById("editform");
            if (form.style.display === "none") {
                form.style.display = "block";
                if (c) {
                    // If `c` is provided, populate the form fields with its data

                    // var name = document.getElementById("inpname").textContent;
                    document.getElementById("edit-name").value = c.name;
                    document.getElementById("edit-email").value = c.email;
                    document.getElementById("edit-website").value = c.website;
                    // Set the action attribute of the form
                    document.getElementById("popup-form2").action =
                        "{{ route('company.update', '') }}/" + c.id;
                }
            } else {
                form.style.display = "none";
                // If the form is closed, reset the form fields and action attribute
                document.getElementById("popup-form2").reset();
                document.getElementById("popup-form2").action = "";
            }
        }

       if("{{$errors->has('name')}}"||"{{$errors->has('email')}}"||"{{$errors->has('logo')}}"||"{{$errors->has('website')}}"){
        openeditform();
       }



        

    </script>
</body>

</html>
