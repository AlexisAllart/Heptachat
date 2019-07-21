// BEGIN - PRESS ENTER TO SEND MESSAGES
$(document).ready(function()
{
    $('#text').keydown(function()
    {
        var message = $("textarea").val();
        if (event.keyCode == 13 && !event.shiftKey)
        {
            $('#form').submit();
            $("textarea").val('');
            return false;
        }
    });
});
// END - PRESS ENTER TO SEND MESSAGES

// BEGIN - AUTOSCROLL LAST MESSAGE
$(function() {
    var objDiv = document.querySelector("#textscroll");
  objDiv.scrollTop = objDiv.scrollHeight;
});
// END - AUTOSCROLL LAST MESSAGE