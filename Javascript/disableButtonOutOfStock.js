
var lagerAntal = "<?php echo $lagerAntal ?>";

var oText = oForm.elements["antal"];

if (oText.value > lagerAntal) {
    document.getElementById("Button").disabled = true;
}
else {
    document.getElementById("Button").disabled = false;
}
    