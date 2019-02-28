/* This code is sandboxed for UI/UX work. The full functionality will be present upon delivering the system. */

$(document).ready(function () {

  $("#register").hide();
  $("#home").hide();
  $("#cabinet").hide();
  $("#search").hide();
  $("#groupnotif").hide();
  $("#pharmacies").hide();
  $("#details").hide();
  $("#review").hide();
  $("#login").show();


  var sideEffectList = [
    "edema",
    "headache",
    "diarrhea",
    "dizziness",
    "drowsiness",
    "hypertension",
    "increased sweating",
    "nausea",
    "dry mouth",
    "insomnia",
    "somnolence"
  ];



  var tagInput = document.querySelector("#reviewTags"),
    tagify = new Tagify(tagInput, {
      whitelist: sideEffectList,
      dropdown: {
        classname: "color-blue",
        enabled: 1,
        maxItems: 5
      },
      addTagOnBlur: false,
      maxTags: 5,
      enforceWhitelist: true
    })

  $("#reviewSubmitBtn").on("click", function () {
    var review_userID = $("#userAccNum").html();
    var review_medID = $("#idForReview").html();
    var review_rating = $("#ratingRange").val();
    var review_birthdate = $("#yearSelect").val();
    var review_side1 = tagify.value[0];
    var review_side2 = tagify.value[1];
    var review_side3 = tagify.value[2];
    var review_side4 = tagify.value[3];
    var review_side5 = tagify.value[4];
    var review_comments = $("#reviewTextarea").val();

    if (review_side1 == undefined)
      review_side1 = "null";
    if (review_side2 == undefined)
      review_side2 = "null";
    if (review_side3 == undefined)
      review_side3 = "null";
    if (review_side4 == undefined)
      review_side4 = "null";
    if (review_side5 == undefined)
      review_side5 = "null";

  });



  // Login page
  $("#loginBtn").on("click", function () {

    if ($("#loginUsername").val() != "" && $("#loginPass").val() != "") {
      $("#userAccDetailsDiv").html();
      $("#login").hide();
      $("#home").show();
    }
  });



  // Login tooltip
  $("#loginTooltipBtn").on("click", function () {
    $("#register").hide();
    $("#login").show();
  });



  // Register tooltip
  $("#registerTooltipBtn").on("click", function () {
    $("#login").hide();
    $("#register").show();
  });



  // Personal cabinet page
  $("#cabinetCard").on("click", function () {
    $("#home").hide();
    $("#cabinet").show();
  });



  // Medicine search page
  $("#searchCard").on("click", function () {
    $("#home").hide();
    $("#search").show();
  });



  // Return to home function
  $(".returnBtn").on("click", function () {
    $("#cabinet").hide();
    $("#search").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#details").hide();
    $("#review").hide();
    $("#home").show();
  });

  $("#returnBtn_details").on("click", function () {
    $("#cabinet").hide();
    $("#search").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#details").hide();
    $("#home").show();
  });



  // Medicine search bar
  $("#medSearchbar").keyup(function () {
    var str = $("#medSearchbar").val();
  });



});






// Opens details of a specific medicine
function openMedDetails(input) {
  $("#home").hide();
  $("#search").hide();
  $("#details").show();
}

function pushNotif() {

}

function openReviewForm(input) {
  $("#cabinet").hide();
  $("#search").hide();
  $("#groupnotif").hide();
  $("#pharmacies").hide();
  $("#details").hide();
  $("#review").show();
  $("#home").hide();
}