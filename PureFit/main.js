// Modal open-close Funktionen
function openmodal(){
    // Get the modal
  var modal = document.getElementById("modal");
  modal.style.display = "block";
  var span = document.getElementsByClassName("close")[0];
  
  

  
  // außerhalb modal
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
     }
    }
  }

  function closemodal(){
    var modal = document.getElementById("modal");
    modal.style.display = "none";
  }
  
  // modal stornieren 
  function openmodalstornieren(){
    var modal = document.getElementById("terminlöschen");
    modal.style.display = "block";
    
    
    window.onclick = function(e) {
      if (e.target == modal) {
        modal.style.display = "none";
       }
      }
  }
 
  // modal trainngplan
 function opentpmodal(){
  var modal = document.getElementById("tpmodal");
  modal.style.display = "block";
  
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
     }
    }
 }
 function closetpmodal(){
    var modal = document.getElementById("tpmodal");
    modal.style.display = "none";
}

//rezeptmodal
function openfrmodal(){
  var modal = document.getElementById("frmodal");
  modal.style.display = "block";
  
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
     }
    }
 }
 function closefrmodal(){
    var modal = document.getElementById("frmodal");
    modal.style.display = "none";
}