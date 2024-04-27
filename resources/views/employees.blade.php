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
    <h2>Here are all the employees of:-</h2>
    <thead>
        <th>Fname</th>
        <th>Lname</th>
        <th>Email</th>
        <th>Phone</th><br>
    </thead>
    <tbody>
        @foreach($emp as $e)
            <tr>{{ $e->fname }}</tr>
            <tr>{{ $e->lname }}</tr>
            <tr>{{ $e->email }}</tr>
            <tr>{{ $e->phone }}</tr>
            <tr><button onclick=openform({{json_encode($e)}})>Edit</button></tr>
            <form id="delete-form-{{ $e->id }}" action="{{ route('employee.destroy', $e->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <tr><button onclick="if(confirm('Are you sure you want to remove this Employee?')) { event.preventDefault(); document.getElementById('delete-form-{{ $e->id }}').submit(); }">Delete</button>
            </tr>
            <br><br>
        @endforeach
    </tbody>
    </table>
    <div class="popup-container" id="birthdayForm">
            <form id="popup-form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @csrf
    FName: <input type="text" name="fname" id="fname">
    LName: <input type="text" name="lname" id="lname">
    Email: <input type="email" name="email" id="email">
    Phone: <input type="text" name="phone" id="phone">
                <button type="submit">Submit</button>
                <button type="button" onclick=openform()>Cancel</button>

            </form>
            </div>

    <script>

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
                document.getElementById("popup-form").action = "{{ route('employee.update', '') }}/" + e.id;
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
