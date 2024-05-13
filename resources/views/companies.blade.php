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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/companies.css') }}">
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
                            href="{{ route("company.index") }}">Company Dashboard </a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("employee.index") }}">Employee Dashboard</a>
                </li>
                <li>
                    <a href="{{ route("company.create") }}"
                        class="btn btn-outline-success my-2 my-sm-0">Add Company</a>
                </li>&nbsp;&nbsp;
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
        <h4 style="margin-left:50px">Company Dashboard:- </h4>
        <a style="margin-left:940px" class="btn btn-primary btn-sm"
            href="{{ route('company.export') }}">Download Companies data in CSV file <i
                class="fa-solid fa-download"></i></a>
    </div><br><br><br>

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

    <!-- Filter options -->
    <div class="container">
        <!-- This is Form to search by Company name -->
        <form action="{{ route('company.index') }}" method="GET" id="searchform">
            <div class="input-group">
                <input type="text" id="search" class="form-control" name="search"
                    placeholder="Search by Company name..." value="{{ request('search') }}">
                <span class="input-group-btn">
                    <button class="btn btn-search" type="submit"><i class="fa fa-search fa-fw"></i> Search</button>
                </span>
                <span class="crossbtn">
                    <button type="button"
                        onclick="document.getElementById('search').value='';document.getElementById('searchform').submit();"
                        class="btn btn-clear crossbtn">X</button>
                </span>
            </div>
        </form>
        <!-- This is filter by status -->
        <form action="{{ route('company.index') }}" method="GET" id="statusform"
            style="width:150px;margin-top:3px;margin-left:1145px">
            <select name="status" class="form-select" onchange="document.getElementById('statusform').submit();"
                placeholder="saa">
                <option value="">Select Status</option>
                <option value="active"
                    {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active</option>
                <option value="inactive"
                    {{ request('status') == 'inactive' ? 'selected' : '' }}>
                    Inactive</option>
            </select>
        </form>

    </div>
    </form>
    </div><br>

    @if($company->isEmpty())
        <h4 style="margin-left:120px;">No Companies found!</h4>
    @endif
    <br><br>

    <!-- This the table to display listed companies -->
    <table class="table container table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Logo</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
                <th scope="col">Employees</th>
            </tr>

        </thead>
        <tbody>
            @foreach($company as $c)
                <tr>
                    <td><a href="{{ route('company.show',$c->id) }}"><img src="{{ $c->logo }}" alt="logo" style="height:40px;width:60px;border-radius: 20px;"></a></td>
                    <td>{{ $c->name }}&nbsp;&nbsp;&nbsp;<a href="{{ $c->website }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->deleted_at?'Inactive':'Active' }}</td>
                    <td><a href="{{ route('employee.index',['id' => $c->id]) }}" style="text-decoration: none;">Get employees <i class="fa-solid fa-forward"></i></a></td>
                    @if(!$c->deleted_at)
                        <td><button onclick="openeditform({{ json_encode($c) }})"
                                class="btn btn-primary btn-sm">Edit</button></td>
                        <td>
                            <form id="delete-form-{{ $c->id }}"
                                action="{{ route('company.destroy', $c->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form><a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Are you sure you want to delete this company?')) { event.preventDefault(); document.getElementById('delete-form-{{ $c->id }}').submit(); }">Delete</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="container">
        {{ $company->links('pagination::bootstrap-5') }}
    </div>

    <!-- This is popup form for editing company details -->
    <div class="popup-container" id="editform">
        <form id="popup-form2" class="formstyle" action="" method="POST" enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <h5>Company Edit Form :-</h5><br>
            <b>Name:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" id="edit-name" value="{{ old('name') }}"><br>
            @if($errors->has('name'))
                <p class="error marginleft">*{{ $errors->first('name') }}</p>
            @endif
            <br>
            <b>Email:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" name="email" id="edit-email" value="{{ old('email') }}"><br>
            @if($errors->has('email'))
                <p class="error marginleft">*{{ $errors->first('email') }}</p>
            @endif
            <br>
            <b>Logo:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="logo" id="edit-logo" value="{{ old('logo') }}"><br>
            @if($errors->has('logo'))
                <p class="error marginleft">*{{ $errors->first('logo') }}</p>
            @endif
            <br>
            <b>Website:</b> &nbsp;<input type="text" name="website" id="edit-website"
                value="{{ old('website') }}"><br>
            @if($errors->has('website'))
                <p class="error marginleft">*{{ $errors->first('website') }}</p>
            @endif
            <br>
            <b>Location:</b> <input type="text" name="location" id="edit-location"
                value="{{ old('location') }}"><br>
            @if($errors->has('location'))
                <p class="error marginleft">*{{ $errors->first('location') }}</p>
            @endif
            <br>

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Save</button>
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


    <script>
        //Popup form to edit companies
        openeditform();

        function openeditform(c) {
            var form = document.getElementById("editform");
            if (form.style.display === "none") {
                form.style.display = "block";
                if (c) {
                    document.getElementById("edit-name").value = c.name;
                    document.getElementById("edit-email").value = c.email;
                    document.getElementById("edit-website").value = c.website;
                    document.getElementById("edit-location").value = c.location;
                    // Set the action attribute of the form
                    document.getElementById("popup-form2").action =
                        "{{ route('company.update', '') }}/" + c.id;
                    localStorage.setItem('id', c.id);
                    console.log(localStorage.getItem('id'));
                }
            } else {
                form.style.display = "none";
            }
        }


        if ("{{ $errors->has('name') }}" || "{{ $errors->has('email') }}" ||
            "{{ $errors->has('logo') }}" || "{{ $errors->has('website') }}" ||
            "{{ $errors->has('location') }}")
        {
            //console.log(localStorage.getItem('id'));
            openeditform();
            document.getElementById("popup-form2").action ="{{ route('company.update', '') }}/" + localStorage.getItem('id');

        }

    </script>
</body>

</html>
