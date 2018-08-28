function themeDark(){
    document.body.style.backgroundImage = "url('img/backgrounds/background3.png')";
    document.getElementById("imgLogo").src = "img/logos/Logo6.png";
    document.getElementById("Bottom").style.backgroundColor = "#0F0F0F";
    document.getElementById("CopyRightText").style.Color = "white";
    document.getElementById("Login").className = "waves-effect orange waves-light btn";
    document.getElementById("Register").className = "waves-effect grey waves-light btn";
    document.getElementById("username").className = "darkTheme";
    document.getElementById("password").className = "darkTheme";
}
function themeWhite(){
    document.body.style.backgroundImage = "url('img/backgrounds/background1.jpg')";
    document.getElementById("imgLogo").src = "img/logos/Logo15.png";
    document.getElementById("Bottom").style.backgroundColor = "#F0F0F0";
    document.getElementById("CopyRightText").style.Color = "darkgrey";
    document.getElementById("Login").className = "waves-effect blue waves-light btn";
    document.getElementById("Register").className = "waves-effect black waves-light btn";
    document.getElementById("Panel").className = "card white darken-1";
    document.getElementById("PanelTitle").className = "card-content black-text";
    document.getElementById("username").className = "lightTheme";
    document.getElementById("password").className = "lightTheme";
}
function post(){
    var user = document.getElementById("username").value;
    var hfid = document.getElementById("hfid").value;
    var reason = document.getElementById("reason").value;
    var part1 = "/GDIRegister/php/server/post.php?user=";
    var part2 = "&id=";
    var part3 = "&reason=";
    window.location.href = part1.concat(user,part2,hfid,part3,reason);
}