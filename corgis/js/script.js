// Hide the "Home" Button for good
$("#title li:eq(0)").css("display", "none");

// chatbox

const toggleChatboxBtn = document.querySelector(".js-chatbox-toggle");
const chatbox = document.querySelector(".js-chatbox");
const chatboxMsgDisplay = document.querySelector(".js-chatbox-display");
const chatboxForm = document.querySelector(".js-chatbox-form");

const createChatBubble = input => {
    const chatSection = document.createElement("p");
    // chatSection.textContent = input;
    // chatSection.classList.add("chatbox__display-chat");
    // chatboxMsgDisplay.appendChild(chatSection);
};
toggleChatboxBtn.addEventListener("click", () => {
    chatbox.classList.toggle("chatbox--is-visible");
    if (chatbox.classList.contains("chatbox--is-visible")) {
        toggleChatboxBtn.innerHTML = '<i class="fas fa-chevron-down"></i>';
    } else {
        toggleChatboxBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    }
});
chatboxForm.addEventListener("submit", e => {
    const chatInput = document.querySelector(".js-chatbox-input").value;
    createChatBubble(chatInput);
    e.preventDefault();
    chatboxForm.reset();
});



// play a sound upon button click
var barkSound = document.getElementById("bark");

$("#boxcard").mouseleave(function() {
    barkSound.pause();
    barkSound.currentTime = 0;
});

$("#boxcard").click(function() {
    barkSound.volume = 0.4;
    barkSound.load();
    barkSound.play();
});

$("#Traits button").click(function() {
    barkSound.volume = 0.4;
    barkSound.load();
    barkSound.play();
});