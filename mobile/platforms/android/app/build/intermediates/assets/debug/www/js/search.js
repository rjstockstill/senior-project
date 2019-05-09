$(document).ready(function() {
  $("#requestBtn").click(function() {
    $.ajax({
      type: "GET",
      url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
      dataType: "html",
      success: function(response) {
        $("#responseDiv").html(response);
      }
    });
  });
});