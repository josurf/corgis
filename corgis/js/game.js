// highlight navbar button corresponding to the current page
$("#title .btn:eq(4)").css("background-color","#DCD7C9")
$("#title .btn:eq(4)").css("border","1px solid #2C3639")
$("#title .btn:eq(4)").css("color","#2C3639")

// appearance tweaks for resizing
if (window.innerWidth >= 1675) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","40%");
	$("#picbox").css("height","50px");
}
else if (window.innerWidth <= 1674 && window.innerWidth >= 1101) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","700px");
	$("#picbox").css("height","130px");
}
else if (window.innerWidth <= 1100 && window.innerWidth >= 995) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","700px");
	$("#picbox").css("height","100px");
}
else if (window.innerWidth <= 994 && window.innerWidth >= 691) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","660px");
	$("#picbox").css("height","350px");
}
else if (window.innerWidth <= 690 && window.innerWidth >= 601) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","65%");
	$("#picbox").css("height","600px");
}
else if (window.innerWidth <= 600) {
	$("#boxcard div").css("width", "100px");
	$("#boxcard div").css("height", "100px");
	$("#picbox").css("width","400px");
	$("#picbox").css("height","550px");
}

$(window).resize(function() {
	if (window.innerWidth >= 1675) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","40%");
		$("#picbox").css("height","50px");
	}
	else if (window.innerWidth <= 1674 && window.innerWidth >= 1101) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","700px");
		$("#picbox").css("height","130px");
	}
	else if (window.innerWidth <= 1100 && window.innerWidth >= 995) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","700px");
		$("#picbox").css("height","100px");
	}
	else if (window.innerWidth <= 994 && window.innerWidth >= 691) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","660px");
		$("#picbox").css("height","350px");
	}
	else if (window.innerWidth <= 690 && window.innerWidth >= 601) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","65%");
		$("#picbox").css("height","600px");
	}
	else if (window.innerWidth <= 600) {
		$("#boxcard div").css("width", "100px");
		$("#boxcard div").css("height", "100px");
		$("#picbox").css("width","400px");
		$("#picbox").css("height","550px");
	}
});

// picture matching game
var boxOpened = "";
var imgOpened = "";
var counter = 0;
var imgFound = 0;

var source = "#boxcard";

var imgSource = [
	"images/corgi%20derp.png",
	"images/nerd%20corgi.png",
	"images/jolly.png",
	"images/gallery/corgi%20on%20floor.png",
	"images/gallery/corgi%20puppy.png",
	"images/gallery/paw%20wave.png",
	"images/gallery/pretty%20corgi.png",
	"images/gallery/puppy%20napping%202.png",
	"images/gallery/puppy%20napping.png"
];

function randomFunction(maxValue, minValue) {
		return Math.floor((Math.random() * maxValue) + minValue);
}
	
function shuffle(array) {
	let currentIndex = array.length,  randomIndex;
  
	// While there remain elements to shuffle.
	while (currentIndex != 0) {
  
	  // Pick a remaining element.
	  randomIndex = Math.floor(Math.random() * currentIndex);
	  currentIndex--;
  
	  // And swap it with the current element.
	  [array[currentIndex], array[randomIndex]] = [
		array[randomIndex], array[currentIndex]];
	}
  
	return array;
}

function shuffleImages() {

	var imgAll = $(source).children();
	var imgThis = $(source + " div:first-child");
	var imgArr = new Array();

	for (var i = 0; i < imgAll.length; i++) {
		imgArr[i] = $("#" + imgThis.attr("id") + " img").attr("src");
		imgThis = imgThis.next();
	}

	for (var z = 0; z < imgAll.length; z++) {
		// imgArr[z] = $("#" + imgThis.attr("id") + " img").attr("src");
		// imgThis = imgThis.next();
		var randomNumber = randomFunction(imgArr.length, 0);
		$("#" + imgThis.attr("id") + " img").eq(z).attr("src", imgArr[randomNumber]);
		imgArr.splice(randomNumber, 1);
		imgThis = imgThis.next();
	}
}

function resetGame() {
	shuffleImages();
	$(source + " div img").hide();
	$(source + " div").css("visibility", "visible");
	counter = 0;
	$("#success").remove();
	$("#counter").html(counter);
	boxOpened = "";
	imgOpened = "";
	imgFound = 0;
	return false;
}

function openCard() {
	var id = $(this).attr("id");
	if ($("#" + id + " img").is(":hidden")) {
		$(source + " div").unbind("click", openCard);
		$("#" + id + " img").slideDown('fast');
		if (imgOpened == "") {
			boxOpened = id;
			imgOpened = $("#" + id + " img").attr("src");
			setTimeout(function() {
				$(source + " div").bind("click", openCard)
			}, 200);
		} else {
			var currentOpened = $("#" + id + " img").attr("src");
			if (imgOpened != currentOpened) {
				setTimeout(function() {
					$("#" + id + " img").slideUp('fast');
					$("#" + boxOpened + " img").slideUp('fast');
					boxOpened = "";
					imgOpened = "";
				}, 600);
			} else {
				$("#" + id + " img").parent().css("visibility", "hidden");
				$("#" + boxOpened + " img").parent().css("visibility", "hidden");
				imgFound++;
				boxOpened = "";
				imgOpened = "";
			}
			setTimeout(function() {
				$(source + " div").bind("click", openCard)
			}, 600);
		}
		counter++;
		$("#counter").html("" + counter);
		if (imgFound == imgSource.length) {
			$("#counter").prepend('<span id="success">Game completed with </span>');
			$("#sendScore").css({'display': 'block', 'text-align': 'center', 'vertical-align': 'middle', 'margin-top': '100px', 'line-height': '30px',});			
		}
	}
}

$.fn.shuffleChildren = function() {
    $.each(this.get(), function(index, el) {
        var $el = $(el);
        var $find = $el.children();

        $find.sort(function() {
            return 0.5 - Math.random();
        });

        $el.empty();
        $find.appendTo($el);
    });
};

$(function() {
	shuffle(imgSource);
	for (var y = 0; y < 1 ; y++) {
		$.each(imgSource, function(i, val) {
			$(source).append("<div id=card" + y + (i+1) + "><img src=" + val + " ></div>");
		});
	}
	for (var y = 1; y < 2 ; y++) {
		$.each(imgSource, function(i, val) {
			$(source).append("<div id=card" + y + i + "><img src=" + val + " ></div>");
		});
	}
	$(source).shuffleChildren();
	$(source + " div").click(openCard);
	shuffleImages();
});