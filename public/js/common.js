// Staff page btn  show and hide
// // $(document).ready(function(){
//   $("#Discontiuation").click(function(){
//     $("#Discont").slideToggle("slow");
//   });
// });

// $(document).ready(function(){
//   $("#reactivate").click(function(){
//     $("#reacti").slideToggle("slow");
//   });
// });

// $(document).ready(function(){
//   $("#eye-btn").click(function(){
//     $("#floatingPassword").attr('type',text);
//   });
// });
function eyebutton(){
  const passwordField = document.getElementById("floatingPassword");
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }

}




// INTERVIEW page
function Textlimit(value) {
  
    if(value.length <= 10) {
        return value;
    }
    
    return value.substring(0, 10) + '...';
  
 }
 
 function queslimit(value) {
    if(value.length <= 50) {
        return value;
    }
    
    return value.substring(0, 50) + '...';
 }
 
 // icon chnaged
window.icons = {
    fullscreen: 'fas fa-arrows-alt',
    export: 'fas fa-download',  
     columns: 'fas fa-list',


  }