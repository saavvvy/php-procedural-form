const container = document.querySelector(".container"),
  pwShowHide = document.querySelectorAll(".showHidePw"),
  pwFields = document.querySelectorAll(".password");

//   code to show hide and show password
pwShowHide.forEach((eyeIcon) => {
  eyeIcon.addEventListener("click", () => {
    // eyeIcon is representing the icons
    pwFields.forEach((pwField) => {
      // pwFields is representing the password input
      if (pwField.type === "password") {
        pwField.type = "text";

        pwShowHide.forEach((icon) => {
          icon.classList.replace("uil-eye-slash", "uil-eye");
        });
      } else {
        pwField.type = "password";

        
        pwShowHide.forEach((icon) => {
          icon.classList.replace("uil-eye", "uil-eye-slash");
        });
      }
    });
  });
});
