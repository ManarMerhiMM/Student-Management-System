if (document.getElementById("alertSuccess")?.textContent.trim() !== "") {
    setTimeout(() => {
        document.getElementById("alertSuccess").style.display = "none";
    }, 4000);
}
