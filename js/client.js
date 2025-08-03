function beforeSubmit(event) {
        event.preventDefault();

        const tel = /^[6789][0-9]{9}$/;
        var mobile = document.querySelector('#mobile').value
        var phone = document.querySelector('#phone').value

        document.querySelector('#err_mob').innerHTML = "";
        document.querySelector('#err_pho').innerHTML = "";

        var isValid = true

        if (phone !== "" && !tel.test(phone)) {
          document.querySelector('#err_pho').innerHTML = "Please enter a valid 10-digit mobile number starting with 6-9.";
          isValid = false;
        }

        if(!mobile || !tel.test(mobile))
        {
          document.querySelector('#err_mob').innerHTML = "Please enter a valid 10-digit mobile number starting with 6-9.";
          isValid = false;
        }
        
        if(isValid){
          document.getElementById("myForm").submit();
        }
      }