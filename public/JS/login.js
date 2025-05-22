function togglePass() {
    if (document.getElementById("hidepass").style.display == "block") {
        document.getElementById("hidepass").style.display = "none";
        document.getElementById("showpass").style.display = "block";
        document.getElementById("password").type = "text";
    }
    else {
        document.getElementById("hidepass").style.display = "block";
        document.getElementById("showpass").style.display = "none";
        document.getElementById("password").type = "password";
    }
}


if (document.getElementById('passError').textContent != "") {
    document.getElementById("hidepass").style.top = "42%";
    document.getElementById("showpass").style.top = "42%";
}