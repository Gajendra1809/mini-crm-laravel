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
<link rel="stylesheet" href="{{asset('css/compDetail.css')}}">
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
                    <a class="nav-link" href="{{ route("employee.index") }}">Employee Dashboard</a>
                </li>
                <li>
                    <a href="{{ route("employee.create",['id'=>$company->id])}}"
                        class="btn btn-outline-success my-2 my-sm-0">Add Employee</a>
                </li>

            </ul>

        </div>
        <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>
    <h4 style="margin-left:50px">Company Details:-</h4><br><br><br>
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

    <div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-2 text-center">
                <div class="row">
                    <div class="col-md-7 border-right no-gutters">
                        <div class="py-3"><img src="{{$company->logo}}" width="100" alt="Logo"><br><br>
                            <h4 class="text-secondary">{{$company->name}}</h4><br><br>
                            <div class="stats">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column"> <span class="text-left head">Email : </span> <span class="text-left bottom"><b>{{$company->email}}</b></span> </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column"> <span class="text-left head">Employees Count : </span> <span class="text-left bottom"><b>{{$company->employee_count}}</b></span> </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="px-3"><a  href="{{ route('employee.index',['id' => $company->id]) }}" class="btn btn-primary btn-block btn-sm">Get Employees</a></div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="py-3">
                        
                        <div class="mt-4"> <span class="d-block head">Status : </span> <span class="bottom"><b>{{$company->deleted_at?'Inactive':'Active'}}</b></span> </div><br>
                            <div > <span class="d-block head">Added on : </span> <span class="bottom"><b>{{$company->created_at}}</b></span> </div><br>
                            <div> <span class="d-block head">Last updated : </span> <span class="bottom"><b>{{$company->updated_at}}</b></span> </div><br>
                            @if($company->deleted_at)
                            <div> <span class="d-block head">Deleted on : </span> <span class="bottom"><b>{{$company->deleted_at}}</b></span> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="popup-container" id="editform">
        <form id="popup-form2" class="formstyle" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            Name: <input type="text" name="name" id="edit-name" value="{{ old('name') }}"><br>
            @if($errors->has('name'))
                <p class="error">*{{ $errors->first('name') }}</p>
            @endif
            Email: <input type="email" name="email" id="edit-email" value="{{ old('email') }}"><br>
            @if($errors->has('email'))
                <p class="error">*{{ $errors->first('email') }}</p>
            @endif
            logo: <input type="file" name="logo" id="edit-logo" value="{{ old('logo') }}"><br>
            @if($errors->has('logo'))
                <p class="error">*{{ $errors->first('logo') }}</p>
            @endif
            Website: <input type="text" name="website" id="edit-website"
                value="{{ old('website') }}"><br>
            @if($errors->has('website'))
                <p class="error">*{{ $errors->first('website') }}</p>
            @endif

            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
                <button type="button" onclick="window.location.reload()" style="background-color: red;">Cancel</button>
            </div>


        </form>
    </div>


    <script>

    </script>
</body>

</html>
