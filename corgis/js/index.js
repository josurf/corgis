// appearance tweaks for resizing
// for ".traitsdiv"
if (window.innerWidth <= 1920 && window.innerWidth >= 1421) {
    $(".traitsdiv").removeClass("col-lg-6");
    $(".traitsdiv").addClass("col-lg-4");
}
else if (window.innerWidth <= 1420 && window.innerWidth >= 921) {
    $(".traitsdiv").removeClass("col-lg-4");
    $(".traitsdiv").addClass("col-lg-6");
    $(".traitsdiv").removeClass("col-md-12");
    $(".traitsdiv").addClass("col-md-6");
}
else if (window.innerWidth <= 920 && window.innerWidth >= 320) {
    $(".traitsdiv").removeClass("col-md-6");
    $(".traitsdiv").addClass("col-md-12");
}

// for ".top-captions div"
if (window.innerWidth >= 1127) {
    $(".top-captions div").removeClass("col-md-12");
    $(".top-captions div").addClass("col-md-6");
    $(".top-captions div").removeClass("col-lg-12");
    $(".top-captions div").addClass("col-lg-6");
}
else if (window.innerWidth <= 1126) {
    $(".top-captions div").removeClass("col-md-6");
    $(".top-captions div").addClass("col-md-12");
    $(".top-captions div").removeClass("col-lg-6");
    $(".top-captions div").addClass("col-lg-12");
}

// for ".traitsdiv"
$(window).resize(function() {
    if (window.innerWidth <= 1920 && window.innerWidth >= 1421) {
    $(".traitsdiv").removeClass("col-lg-6");
    $(".traitsdiv").addClass("col-lg-4");
    }
    else if (window.innerWidth <= 1420 && window.innerWidth >= 921) {
        $(".traitsdiv").removeClass("col-lg-4");
        $(".traitsdiv").addClass("col-lg-6");
        $(".traitsdiv").removeClass("col-md-12");
        $(".traitsdiv").addClass("col-md-6");
    }
    else if (window.innerWidth <= 920 && window.innerWidth >= 320) {
        $(".traitsdiv").removeClass("col-md-6");
        $(".traitsdiv").addClass("col-md-12");
    }
});

// for ".top-captions div"
$(window).resize(function() {
    if (window.innerWidth <= 1920 && window.innerWidth >= 1127) {
        $(".top-captions div").removeClass("col-md-12");
        $(".top-captions div").addClass("col-md-6");
        $(".top-captions div").removeClass("col-lg-12");
        $(".top-captions div").addClass("col-lg-6");
    }
    else if (window.innerWidth <= 1126 && window.innerWidth >= 765) {
        $(".top-captions div").removeClass("col-md-6");
        $(".top-captions div").addClass("col-md-12");
        $(".top-captions div").removeClass("col-lg-6");
        $(".top-captions div").addClass("col-lg-12");
    }
});

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

var images = document.getElementsByClassName("traitsimg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

for (i = 0; i < images.length; i++) {
    images[i].onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        modalImg.alt = this.alt;
        captionText.innerHTML = (this.nextElementSibling.innerHTML + "Corgi");
    }
}

// convert table Weight, pounds to kg and vice versa
var weights = $(".weight")
$("#weightToggle").click(function() {
    if (this.innerHTML == "lbs") {
        this.innerHTML = ("kg")
        weights[0].innerHTML = ("Up to 14 kg");
        weights[1].innerHTML = ("Up to 13 kg");
    }
    else if (this.innerHTML == "kg") {
        this.innerHTML = ("lbs")
        $(".weight")[0].innerHTML = ("Up to 30 lbs");
        $(".weight")[1].innerHTML = ("Up to 28 lbs");
    }
});

// convert table Height, inches to cm and vice versa
$("#heightToggle").click(function() {
    if (this.innerHTML == "inches") {
        this.innerHTML = ("cm")
        $(".height")[0].innerHTML = ("25 to 31 cm tall at the shoulder");
    }
    else if (this.innerHTML == "cm") {
        this.innerHTML = ("inches")
        $(".height")[0].innerHTML = ("10 to 12 inches tall at the shoulder");
    }
});