
function checkAmount(){
    var oText = document.getElementById("antal");
    var number = parseInt(oText.value);
    var lagerNumber = parseInt(lagerAntal);

    if (number > lagerNumber ) {
        document.getElementById("btnSubmit").disabled = true;
        document.getElementById("largeOrder").innerHTML = "Your order is to large";
    }
    else if (number == 0) {
      document.getElementById("btnSubmit").disabled = true;
      document.getElementById("largeOrder").innerHTML = " ";
    }
    else {
        document.getElementById("btnSubmit").disabled = false;
        document.getElementById("largeOrder").innerHTML = " ";
    }
}
