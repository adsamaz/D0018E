$(function(){
    // this will get the full URL at the address bar
    var url = window.location.href;

    // passes on every "a" tag
    $(".menu a").each(function() {
            // checks if its the same on the address bar
        if(url == (this.href)) {
            $(this).closest("li").addClass("active");
        }
    });
    $(".tablinks").each(function() {
            // checks if its the same on the address bar
        if(url == (this.href)) {
            $(this).addClass("activeTab");
        }
    });
});
