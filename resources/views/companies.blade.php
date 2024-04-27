<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
max-width: 400px; /* Set maximum width */
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
    </style>
</head>

<body>
    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif
    @if(session()->has('error'))
        <p>{{ session('error') }}</p>
    @endif
    <h2>Here are all the companie:-</h2>
    <thead>
        <th>Logo</th>
        <th>Company Name</th>
        <th>Email</th>
        <th>Website</th>
        <th>Employees</th><br>
    </thead>
    <tbody>
        @foreach($company as $c)
            <tr><img src="{{ $c->logo }}" alt="logo" style="width:50px"></tr>
            <tr>{{ $c->name }}</tr>
            <tr>{{ $c->email }}</tr>
            <tr><a href="{{ $c->website }}">{{ $c->website }}</a></tr>
            <tr><a
                    href="{{ route('employee.index',['id' => $c->id]) }}">Get
                    employees</a></tr>
            <tr><button onclick=openform({{json_encode($c)}})>Edit</button></tr>
            <form id="delete-form-{{ $c->id }}"
                action="{{ route('company.destroy', $c->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <tr><button><a href="#" onclick="if(confirm('Are you sure you want to delete this company?')) { event.preventDefault(); document.getElementById('delete-form-{{ $c->id }}').submit(); }">Delete</a></button>
            </tr>
            <br><br>
        @endforeach
    </tbody>
    </table>
    <div class="popup-container" id="birthdayForm">
            <form id="popup-form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                Name: <input type="text" name="name" id="name" >
                Email: <input type="email" name="email" id="email" >
                logo: <input type="file" name="logo" id="">
                Website: <input type="text" name="website" id="website">

                <button type="submit">Submit</button>
                <button type="button" onclick=openform()>Cancel</button>

            </form>
            </div>

    <script>

        //Pop form to add bithday
        openform();
        function openform(c) {
            var form = document.getElementById("birthdayForm");
            if (form.style.display === "none") {
                form.style.display = "block";
                console.log(c);
            if (c) {
                // If `c` is provided, populate the form fields with its data
                document.getElementById("name").value = c.name;
                document.getElementById("email").value = c.email;
                document.getElementById("website").value = c.website;
                // Set the action attribute of the form
                document.getElementById("popup-form").action = "{{ route('company.update', '') }}/" + c.id;
            }
        } else {
            form.style.display = "none";
            // If the form is closed, reset the form fields and action attribute
            document.getElementById("popup-form").reset();
            document.getElementById("popup-form").action = "";
            }
        }

    </script>
</body>

</html>
