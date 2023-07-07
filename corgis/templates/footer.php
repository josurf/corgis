<!-- play a sound upon button click -->
<input type="button" value="PLAY" onclick="play()" style="visibility: hidden;">
<audio id="bark" src="./sounds/dogBark.mp3"></audio>

<!-- Footer -->
<section class="Footer">
    <div class="container">
		<footer class="py-3 my-4">
			<ul class="nav justify-content-center border-bottom pb-3 mb-3">
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>index.php" class="nav-link px-2 text-muted">Home</a></li>
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>aboutMe.php" class="nav-link px-2 text-muted">About Me</a></li>
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>gallery.php" class="nav-link px-2 text-muted">Gallery</a></li>
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>contact.php" class="nav-link px-2 text-muted">Contact</a></li>
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>game.php" class="nav-link px-2 text-muted">Game</a></li>
				<li class="nav-item"><a href="<?php echo SITE_ROOT; ?>shop.php" class="nav-link px-2 text-muted">Shop</a></li>
			</ul>
			<p class="text-center text-muted"><a href="#"><i class="fa-brands fa-facebook"></i></a> <a href="#"><i class="fa-brands fa-twitter"></i></a> <a href="#"><i class="fa-brands fa-instagram"></i></a> <a href="#"><i class="fa-solid fa-share-nodes"></i></a></p>
		</footer>
    </div>
</section>

<!-- chatbox -->
<section class="chatbox js-chatbox">
    <div class="chatbox__header">
		<h3 class="chatbox__header-cta-text"><span class="chatbox__header-cta-icon"><i class="fas fa-comments"></i></span>Bark Box</h3>
		<button class="js-chatbox-toggle chatbox__header-cta-btn u-btn"><i class="fas fa-chevron-up"></i></button>
    </div>
    <div id="chatBody" class="js-chatbox-display chatbox__display">
		<div id="botDisplay" class="messages"></div>
		<div class="seperator"></div>  
		<div id="botMessage" class="messages"></div>
		<div class="seperator"></div>  
	</div>
    <form id="inputArea" name="inputForm" class="js-chatbox-form chatbox__form" method="POST">
		<input type="text" name="messages" id="inputMessage" class="js-chatbox-input chatbox__form-input" placeholder="Type your message..." autocomplete="off">
		<button class="chatbox__form-submit u-btn" name="inputButton" type="submit" id="inputButton"><i class="fa-solid fa-arrow-right"></i></button>
    </form>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/5975090965.js" crossorigin="anonymous"></script>

<!-- jquery and js -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="js/script.js"></script>

<?php 
if(!isAdmin()) {
	echo '<script>$("#adminButton").css("display", "none")</script>';
}

$now = date("H:i:s");
?>

<script>
	// window.setInterval(function() {
	// var elem = document.getElementById('chatBody');
	// elem.scrollTop = elem.scrollHeight;
	// }, 3000);

	$(document).ready(function(){
		load_data();
		function load_data(query){
			$.ajax({
				url: "chatQuery.php",
				method: "POST",
				data:{
					query: query
				},
				success:function(data){
                    $('#chatBody').append(data);
				}
			});
		}
		$("#inputButton").click(function(){
			var message = $("#inputMessage").val();

			if(message && !(!/\S/.test(message))){
				$('#chatBody').append("<div class='messages botDisplay'><table><tr><td style:'max-width:30%;'>" + message + "</td><td style='padding-left:20%;color:green;max-width:30%;font-size:smaller;'> <?php echo $now;?></td></tr></table></div>");
				load_data(message);
			// } else {
			// 	load_data('');
			}
			var elem = document.getElementById('chatBody');
			elem.scrollTop = elem.scrollHeight;
		});
	});

</script>