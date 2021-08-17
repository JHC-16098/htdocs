/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  } 



  function validateSearch() {
    bannedChars = ["'", "\"", "(", ")"];
    let form = document.forms["search"]["search"].value;
    for (index = 0; index < bannedChars.length; index++) {
      console.log(form);
      if(form.includes(")")) {
         alert("Please do not use the following characters: " + bannedChars);
         return false;
       }
    }
  }

  //bannedChars[index])