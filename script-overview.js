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