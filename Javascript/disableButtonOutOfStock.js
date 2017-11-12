
function checkAmount(){
    var oText = document.getElementById("antal");
    var number = parseInt(oText.value);
    var lagerNumber = parseInt(lagerAntal);

    if (number > lagerNumber || number == 0) {
        document.getElementById("btnSubmit").disabled = true;
        document.getElementById("largeOrder").innerHTML = "Your order is to large";
    }
    else {
        document.getElementById("btnSubmit").disabled = false;
        document.getElementById("largeOrder").innerHTML = " ";
    }
}
