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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
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
        @guest
            <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("login.get") }}"
                    class="text-danger">Login</a></button>&nbsp;&nbsp;
        @endguest
        @auth
            <h6 class="mt-2">{{ auth()->user()->name }}&nbsp;&nbsp;</h6>
            <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                    class="text-danger">Logout</a></button>&nbsp;&nbsp;
        @endauth
    </nav><br><br><br><br>

    <!-- This is to handle messages sent through session -->
    @if(session()->has('success'))
        <div class="alert alert-success msgpopup">
            <strong>Success!</strong> {{ session('success') }}👍
        </div>
        {{ session()->forget('success') }}
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger msgpopup">
            <strong>Something went wrong!</strong> {{ session('error') }}
        </div>
        {{ session()->forget('error') }}
    @endif

    <div style="display: flex;justify-content: center;align-items: center;margin-left: 150px;margin-top: 100px;">
        <div class="row mx-auto">
             <!-- Company manipulation card -->
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body" style="width:800px">
                        <h5 class="card-title">Company Manipulation</h5>
                        <p class="card-text">Total companies :- {{ $analyticsData->total_company }} on this plateform
                        </p>
                        <a href="{{ route('company.create') }}" class="btn btn-primary btn-sm">Add
                            Company +</a>
                        <a href="{{ route('company.index') }}" class="btn btn-primary btn-sm">Company
                            Dashboard -></a>
                    </div>
                    <div id="myChart" style="width:100%; max-width:600px; height:300px;"></div>
                </div>
            </div>
            <!-- Employee manipulation card -->
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employee Manipulation</h5>
                        <p class="card-text">Total Employees :- {{ $analyticsData->total_employee }} on this plateform
                        </p>
                        <a href="{{ route('employee.create') }}" class="btn btn-primary btn-sm">Add
                            Employee +</a>
                        <a href="{{ route('employee.index') }}"
                            class="btn btn-primary btn-sm">Employee Dashboard -></a>
                    </div>
                    <div id="myChart2" style="width:100%; max-width:600px; height:300px;"></div>
                </div>
            </div>
        </div>
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
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // Set company Data
            const company = google.visualization.arrayToDataTable([
                ['Company', 'Count'],
                ['Week', parseInt("{{ $analyticsData->last_week_comp }}")],
                ['Month', parseInt("{{ $analyticsData->last_month_comp }}")],
                ['Total', parseInt("{{ $analyticsData->total_company }}")]
            ]);
            // Set employee Data
            const employee = google.visualization.arrayToDataTable([
                ['Employee', 'Count'],
                ['Week', parseInt("{{ $analyticsData->last_week_emp }}")],
                ['Month', parseInt("{{ $analyticsData->last_month_emp }}")],
                ['Total', parseInt("{{ $analyticsData->total_employee }}")]
            ]);

            // Set Options
            const options = {
                title: 'Resource count analitics :-'
            };

            // Draw
            const companyChart = new google.visualization.BarChart(document.getElementById('myChart'));
            companyChart.draw(company, options);
            const employeeChart = new google.visualization.BarChart(document.getElementById('myChart2'));
            employeeChart.draw(employee, options);

        }

    </script>


</body>

</html>
