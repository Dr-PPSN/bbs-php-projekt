function displayMessage(message){
    if (!message==""){
        var body = $("body");
        $(body).append("<div id='message_div'></div>")
        $("#message_div").append("<div>" + message + "</div>");
        setTimeout(
            function() {
                $("#message_div").fadeOut(1000);
            }, 3000);
            setTimeout(
                function() {
                $("#message_div").remove();
                }, 6000);
    }
}
$( document ).ready(function() {
    if($("#tableElement").text().length > 0){
        //$("#btnAnzeigen").click();
    }
});