var rows = 3;
var columns = 3;

var currTile;
var otherTile; //blank tile

var turns = 0;

function mélangerImage(array) {
    for (let i = array.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    console.log(array);
}

// var imgOrder = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
var imgOrder = ["4", "2", "8", "5", "1", "6", "7", "9", "3"];

mélangerImage(imgOrder);

window.onload = function() {
    for (let r=0; r < rows; r++) {
        for (let c=0; c < columns; c++) {

            //<img id="0-0" src="1.jpg">
            let tile = document.createElement("img");
            tile.id = r.toString() + "-" + c.toString();
            tile.src = imgOrder.shift() + ".jpg";

            //DRAG FUNCTIONALITY
            tile.addEventListener("dragstart", dragStart);  //click an image to drag
            tile.addEventListener("dragover", dragOver);    //moving image around while clicked
            tile.addEventListener("dragenter", dragEnter);  //dragging image onto another one
            tile.addEventListener("dragleave", dragLeave);  //dragged image leaving anohter image
            tile.addEventListener("drop", dragDrop);        //drag an image over another image, drop the image
            tile.addEventListener("dragend", dragEnd);      //after drag drop, swap the two tiles

            document.getElementById("board").append(tile);

        }
    }
}

function dragStart() {
    currTile = this; //this refers to the img tile being dragged
}

function dragOver(e) {
    e.preventDefault();
}

function dragEnter(e) {
    e.preventDefault();
}

function dragLeave() {

}

function dragDrop() {
    otherTile = this; //this refers to the img tile being dropped on
}

function dragEnd() {
    // if (!otherTile.src.includes("3.jpg")) {
    //     return;
    // }

    let currCoords = currTile.id.split("-"); //ex) "0-0" -> ["0", "0"]
    let r = parseInt(currCoords[0]);
    let c = parseInt(currCoords[1]);

    let otherCoords = otherTile.id.split("-");
    let r2 = parseInt(otherCoords[0]);
    let c2 = parseInt(otherCoords[1]);

    let moveLeft = r == r2 && c2 == c-1;
    let moveRight = r == r2 && c2 == c+1;

    let moveUp = c == c2 && r2 == r-1;
    let moveDown = c == c2 && r2 == r+1;

    let isAdjacent = moveLeft || moveRight || moveUp || moveDown;

    if (isAdjacent) {
        let currImg = currTile.src;
        let otherImg = otherTile.src;

        currTile.src = otherImg;
        otherTile.src = currImg;

    }

}

let failedAttempts = 0;

function puzzleValidate() {
    if(
    document.getElementById('0-0').src.endsWith('1.jpg') && 
    document.getElementById('0-1').src.endsWith('2.jpg') &&
    document.getElementById('0-2').src.endsWith('3.jpg') &&
    document.getElementById('1-0').src.endsWith('4.jpg') &&
    document.getElementById('1-1').src.endsWith('5.jpg') &&
    document.getElementById('1-2').src.endsWith('6.jpg') &&
    document.getElementById('2-0').src.endsWith('7.jpg') &&
    document.getElementById('2-1').src.endsWith('8.jpg') &&
    document.getElementById('2-2').src.endsWith('9.jpg') )
    { showPopupValidation('Captcha validé <br/> Vous allez être redirigé');

} else {
    failedAttempts++
    if (failedAttempts >= 4){
        window.close();
    }
  showPopup('NOOOOOOOOON'); 
}
}

function showPopup(message) {
const popup = document.getElementById('popup');
const popupMessage = document.getElementById('popup-message');

popupMessage.textContent = message;
popup.style.display = 'block';

const closeBtn = document.getElementById('popup-close-btn');
closeBtn.addEventListener('click', closePopup);
}

function closePopup() {
const popup = document.getElementById('popup');
popup.style.display = 'none';
}


function showPopupValidation(message) {
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popup-message');
    
    popupMessage.innerHTML = message;
    popup.style.display = 'block';
    
    const closeBtn = document.getElementById('popup-close-btn');
    closeBtn.addEventListener('click', closePopupValidation);
    
    // Redirect after 3 seconds (adjust the delay as needed)

    // Create a new FormData object
var formData = new FormData();

// Get the values from hidden inputs based on their IDs
var gender = document.getElementById('gender').value;
var firstname = document.getElementById('firstname').value;
var lastname = document.getElementById('lastname').value;
var email = document.getElementById('email').value;
var pwd = document.getElementById('pwd').value;
var pwdConfirm = document.getElementById('pwdConfirm').value;
var birthday = document.getElementById('birthday').value;
var country = document.getElementById('country').value;
var cgu = document.getElementById('cgu').value;

// Append the data to the FormData object
formData.append('gender', gender);
formData.append('firstname', firstname);
formData.append('lastname', lastname);
formData.append('email', email);
formData.append('pwd', pwd);
formData.append('pwdConfirm', pwdConfirm);
formData.append('birthday', birthday);
formData.append('country', country);
formData.append('cgu', cgu);


// Make the POST request
fetch('../core/userAdd.php', {
  method: 'POST',
  body: formData
})
  .then(response => response.json())
  .then(data => {
    // Handle the response data
  })
  .catch(error => {
    // Handle any errors
  });

    setTimeout(() => {
        window.location.href = "../index.php";
    }, 3000);
}

function closePopupValidation() {
    const popup = document.getElementById('popup');
    popup.style.display = 'none';
    
    // Redirect immediately
    window.location.href = "../index.php";
}
// let btn = document.querySelector(".btn");
// btn.addEventListener("click", puzzleValidate);


// document.getElementById('modal').style.display = 'block'

// window.addEventListener('scroll', function(e) {
//     setTimeout( () => {
//       document.getElementById('modal').style.display = 'block'
//     }, 2000 )
//   });


// function showPopUp() {
//     document.getElementById("modal").style.display = "block";
//     }   
//     function closePopUp() {
//     document.getElementById("modal").style.display = "none";
//     }

// créer une fonction qui enregistre le déplacement des cases à chaque drag and drop 
//afin d'évaluer la position des cases pour les comparer

