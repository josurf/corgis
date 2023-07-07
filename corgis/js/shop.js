// highlight navbar button corresponding to the current page
$("#title .btn:eq(5)").css("background-color","#DCD7C9")
$("#title .btn:eq(5)").css("border","1px solid #2C3639")
$("#title .btn:eq(5)").css("color","#2C3639")

// "back to top" button
var btn = $('#button');

$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});

btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
});

// image pop out
var modal = document.getElementById("myModal");
var span = $(".close");

span.on("click", function() {
    modal.style.display = "none";
});

var images = document.getElementsByClassName("shopImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

for (i = 0; i < images.length; i++) {
    images[i].onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        modalImg.alt = this.alt;
        captionText.innerHTML = (this.nextElementSibling.innerHTML);
    }
}