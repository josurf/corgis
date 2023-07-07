// highlight navbar button corresponding to the current page
$("#title .btn:eq(1)").css("background-color","#DCD7C9")
$("#title .btn:eq(1)").css("border","1px solid #2C3639")
$("#title .btn:eq(1)").css("color","#2C3639")

// underline text "form"
$("#Profile span").css("text-decoration", "underline");

// image pop out
var modal = document.getElementById("myModal");
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function() {
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
  modal.style.display = "none";
}

// animate text fade in
const text = document.querySelector(".profile-text h3");
const strText = text.textContent;
const splitText = strText.split("");
text.textContent = "";

for(let i=0; i < splitText.length; i++) {
  text.innerHTML += "<span>" + splitText[i] + "</span>";
}

let char = 0;
let timer = setInterval(onTick, 50);

function onTick() {
  const span = text.querySelectorAll('span')[char];
  span.classList.add('fade');
  char++;
  if(char === splitText.length) {
    complete();
    return;
  }
}

function complete() {
  clearInterval(timer);
  timer = null;
}