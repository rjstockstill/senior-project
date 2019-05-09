$(document).ready(function () {
  $("#home").show();
  $("#search").hide();

  $("#searchCard").on("click", function () {
    $("#home").hide();
    $("#search").show();
    $.ajax({
      type: "GET",
      url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
      dataType: "html",
      success: function (response) {
        $("#responseDiv").html(response);
      }
    });
  });

  $("#returnBtn").on("click", function () {
    $("#home").show();
    $("#search").hide();
  });
});