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
             // Setting the action attribute of the form
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