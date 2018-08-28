function sendReq(){
    alert("test");
    if ($("#g-recaptcha-response").val()) {
$.ajax({
type: ‘GET’,
url: "reg.php", 
dataType: ‘html’,
async: true,
data: {
captchaResponse: $("#g-recaptcha-response").val(),
mail: document.getElementById("mail").value(),
},
success: function (data) {
alert("everything looks ok");
},
error: function (XMLHttpRequest, textStatus, errorThrown) {
alert("You’re a bot");
}
});
} else {
alert("Please fill the captcha!");
}
});
}