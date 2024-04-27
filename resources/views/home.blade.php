<h1>home {{auth()->user()}}</h1>

<button><a href="{{route('logout')}}">logout</a></button>

@if (session()->has('success'))
    <p>{{session('success')}}</p>
@endif
@if (session()->has('error'))
    <p>{{session('error')}}</p>
@endif


<h2>Add company</h2> 
<button><a href="{{route('company.index')}}">Get all companies</a></button>

<form action="{{route('company.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    Name: <input type="text" name="name" id="">
    Email: <input type="email" name="email" id="">
    logo: <input type="file" name="logo" id="">
    Website: <input type="text" name="website" id="">

    <button>Submit</button>

</form>

<h2>Add Employees</h2>
<form action="{{route('employee.store')}}" method="POST">
    @csrf
    FName: <input type="text" name="fname" id="">
    LName: <input type="text" name="lname" id="">
    Email: <input type="email" name="email" id="">
    Phone: <input type="text" name="phone" id="">
    Company: 
    <select name="company_id" id="">
        <option value=""></option>
        @foreach ($companies as $c)
            <option value="{{$c->id}}">{{$c->name}}</option>
        @endforeach
    </select>

    <button>Submit</button>

</form>