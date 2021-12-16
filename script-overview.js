function one(q){
    return document.querySelector(q)
}

function all(q){
    return document.querySelectorAll(q)
}

function foldAside(dropdownID, arrowID) {
    let boxID = one(dropdownID)
    let boxIDStyle = getComputedStyle(boxID, null).display
    if (boxIDStyle != 'block') {
        boxID.style.display = "block"
        one(arrowID).classList = "fas fa-angle-up"
    } else {
        boxID.style.display = "none"
        one(arrowID).classList = "fas fa-angle-down"
    }
} 

// When the user scrolls the page, execute myFunction
window.onscroll = function() {stickyBar()};

// Get the navbar
var navbar = one(".nav_bar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function stickyBar() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}