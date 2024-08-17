function checkInputs() {
    var input1Value = document.getElementById("currentPassword").value;
    var input2Value = document.getElementById("newPassword").value;
    var input3Value = document.getElementById("newPasswordConfirmation").value;
    var input4 = document.getElementById("btn-password-disabled");
  
    if (input1Value && input2Value && input3Value) {
      input4.disabled = false;
      input4.classList.remove("btn-light");
      input4.classList.add("btn-success");
    } else {
      input4.disabled = true;
      input4.classList.remove("btn-success");
      input4.classList.add("btn-light");
    }
  }
  