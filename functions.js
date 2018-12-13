function backToBerufsbildner() {
    alert("Test 123, Test 123");
}

var moduledisplay = false;

function displayModules() {

    if(moduledisplay == false) {
        document.getElementById("modules").style.display = "block";
        document.getElementById("moduleButton").innerText = "Module anzeigen";
        moduledisplay = true;
    }
    else {
        document.getElementById("modules").style.display = "none";
        document.getElementById("moduleButton").innerText = "Module ausblenden";
        moduledisplay = false;
    }
}