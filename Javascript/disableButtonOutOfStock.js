
//var lagerAntal = <?php echo $lagerAntal; ?>;
//lagerAntal = parseInt(lagerAntal);
function checkAmount(){
    var oText = document.getElementById("antal");
    //Number.isInteger(oText.value)
    var number = parseInt(oText.value);
    var lagerNumber = parseInt(lagerAntal);
    //console.log(doucment);
    //console.log(document.getElementById("antal"));
    if (number > lagerNumber || number == 0) {
        document.getElementById("btnSubmit").disabled = true;
        document.getElementById("largeOrder").innerHTML = "Your order is to large";
    }
    else {
        document.getElementById("btnSubmit").disabled = false;
        document.getElementById("largeOrder").innerHTML = " ";
    }
}
