function backToBerufsbildner() {
    alert("Test 123, Test 123");
}

var moduledisplay = false;

function displayModules() {
    document.getElementById("modules").innerText = "<?php showModules(); ?>";

    if(moduledisplay == false) {
        document.getElementById("modules").style.display = "block";
        document.getElementById("moduleButton").innerText = "Module ausblenden";
        moduledisplay = true;
    }
    else {
        document.getElementById("modules").style.display = "none";
        document.getElementById("moduleButton").innerText = "Module anzeigen";
        moduledisplay = false;
    }
}