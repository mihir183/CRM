function beforeSubmit(event) {

    event.preventDefault();

    var user = document.querySelector('#user').value
    var email = document.querySelector('#email').value
    var pass = document.querySelector('#pass').value
    var cpass = document.querySelector('#cpass').value

    var isValid = true;

    if(!user || !email || !pass || !cpass || pass !== cpass)
    {
        alert("Invalid input, please check your details.");
        isValid = false;
    }
    
    if(isValid){
        document.getElementById("regForm").submit();
    }
}