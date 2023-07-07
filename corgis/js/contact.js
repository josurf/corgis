// highlight navbar button corresponding to the current page
$("#title .btn:eq(3)").css("background-color","#DCD7C9")
$("#title .btn:eq(3)").css("border","1px solid #2C3639")
$("#title .btn:eq(3)").css("color","#2C3639")

// email validation
// const email = document.querySelector('input[type=email]');
// const button = document.querySelector('#Contact #btn');
// const text =  document.querySelector('#message');
// const msg = document.getElementsByTagName('textarea')[0]

// const validateEmail= (email) => {
//     var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return regex.test(String(email).toLowerCase());
// }

// function submitForm() {
//     if(email.value.length == 0) {
//         text.innerText="Please enter your email";
//         return false;
//     } 
//     else if(!validateEmail(email.value)) {
//         text.innerText="Invalid email";
//         return false;
//     } 
//     else if (msg.value.length = 0) {
//         text.innerText="Please enter 30 or more characters";
//         return false;
//     }
//     else if (msg.value.length < 30) {
//         text.innerText="Please enter " + (30 - msg.value.length) + " more characters";
//         return false;
//     }
//     else if (validateEmail(email.value) && msg.value.length >= 30) {
//         text.innerText="Form Submitted";
//         alert("Form Submitted!");
//     }
// };
