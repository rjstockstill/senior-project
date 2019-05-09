/*
Main app functions.
Includes some global vars, local functions, and native hooks.
*/



/*
TO DO:
X Remember if a user is logged in.
X Larger side effects list.
X Complete review reply system.
X Complete account settings.
X Complete locater page.
X Complete group notif system.
- Allow users to edit reviews.
- Complete review liking system.
- Migrate image search from NLM API to server images and .tab data.
*/



var counter = 0;
var userAccNum_global;
var friendAccNum_global;
var friendName_global;
var review_id_global;
var chat_interval = null;
var loader = "<img src='img/loader2.gif' style='display:block; margin-left:auto; margin-right:auto; margin-top:200px; width:80px;'>";

$(document).ready(function () {

  console.log("LS username: " + localStorage.thisUsername);
  console.log("LS password: " + localStorage.thisPassword);

  function onDeviceReady() {
    //
  }

  window.isphone = false;
  if (document.URL.indexOf("http://") === -1 && document.URL.indexOf("https://") === -1) {
    window.isphone = true;
  }

  if (window.isphone) {
    document.addEventListener("deviceready", onDeviceReady, false);
  } else {
    onDeviceReady();
  }

  $("#register").hide();
  $("#home").hide();
  $("#cabinet").hide();
  $("#search").hide();
  $("#groupnotif").hide();
  $("#pharmacies").hide();
  $("#details").hide();
  $("#review").hide();
  //$("#review_edit").hide();
  $("#review_all").hide();
  $("#mednotification").hide();
  $("#accountsettings").hide();
  $("#accountsettings_edit").hide();
  $("#usersearchheader").hide();
  $("#grouptab_message_box").hide();
  $("#chatroom").hide();
  $("#login").show();



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

    console.log(review_birthdate);

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

    $.ajax({
      type: "POST",
      async: false,
      url: "http://www2.cs.siu.edu/~mls/deploy/post_review.php",
      data: {
        "review_userID": review_userID,
        "review_medID": review_medID,
        "review_rating": review_rating,
        "review_birthdate": review_birthdate,
        "review_side1": review_side1.value,
        "review_side2": review_side2.value,
        "review_side3": review_side3.value,
        "review_side4": review_side4.value,
        "review_side5": review_side5.value,
        "review_comments": review_comments
      },
      dataType: "html",
      success: function (response) {
        console.log(response);
        //hide review form, show details, refresh details
        $("#review").hide();
        $("#detailResponseDiv").html("");
        $("#medReviewsDiv").html("");
        openMedDetails(review_medID, " ", " ", " ");
        $("#responseDiv").html("");
        $.ajax({
          type: "GET",
          url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
          data: {
            medSearchbar: $("#medSearchbar").val()
          },
          dataType: "html",
          success: function (response) {
            $("#responseDiv").html(response);
          }
        });
      }
    });
  });





  if (localStorage.thisUsername != undefined && localStorage.thisPassword != undefined) {
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/app_login.php",
      data: {
        'loginUsername': localStorage.thisUsername,
        'loginPass': localStorage.thisPassword
      },
      dataType: "html",
      success: function (response) {
        if (response != "") {
          $("#userAccDetailsDiv").html(response);
          $("#login").hide();
          $("#home").show();
          userAccNum_global = $("#userAccNum").html();
        } else {
          $("#errorMsg").html("Incorrect username or password");
        }
      }
    });
  }



  $("#settings_logout").on("click", function () {
    if (confirm("Are you sure you want to log out?")) {
      window.localStorage.clear();
      $("#home").hide();
      $("#accountsettings").hide();
      $("#login").show();
      //window.localStorage.setItem("thisUsername", undefined);
      //window.localStorage.setItem("thisPassword", undefined);
    } else {
      //
    }
  });







  // Login page
  $("#loginBtn").on("click", function () {

    if ($("#loginUsername").val() != "" && $("#loginPass").val() != "") {
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/app_login.php",
        data: {
          'loginUsername': $("#loginUsername").val(),
          'loginPass': $("#loginPass").val()
        },
        dataType: "html",
        success: function (response) {
          if (response != "") {
            $("#userAccDetailsDiv").html(response);
            $("#login").hide();
            $("#home").show();
            userAccNum_global = $("#userAccNum").html();
            localStorage.thisUsername = $("#loginUsername").val();
            localStorage.thisPassword = $("#loginPass").val();
            //console.log(localStorage.thisUsername);
          } else {
            $("#errorMsg").html("Incorrect username or password");
          }
        }
      });
    } else {
      $("#errorMsg").html("Please fill out all fields");
    }
  });



  // Register page
  $("#registerBtn").on("click", function () {

    if ($("#registerUsername1").val() != "" && $("#registerPass1").val() != "" && ($("#registerUsername1").val() == $("#registerUsername2").val()) && ($("#registerPass1").val() == $("#registerPass2").val()) && $("#registerFirstname").val() != "" && $("#registerLastname").val() != "" && $("#registerAddress").val() != "" && $("#registerCity").val() != "" && $("#registerState").val() != "") {
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/app_register.php",
        data: {
          'registerUsername': $("#registerUsername1").val(),
          'registerPass': $("#registerPass1").val(),
          'registerFirstname': $("#registerFirstname").val(),
          'registerLastname': $("#registerLastname").val(),
          'registerAddress': $("#registerAddress").val(),
          'registerCity': $("#registerCity").val(),
          'registerState': $("#registerState").val()
        },
        dataType: "text",
        success: function (response) {
          if (response == "success") {
            alert("Account created successfully. Please log in.");
            $("#register").hide();
            $("#login").show();
          } else {
            $("#errorMsgReg").html("That username already exists");
          }
        }
      });
    } else {
      $("#errorMsgReg").html("Please fill out all fields");
    }
  });



  // Login tooltip
  $("#loginTooltipBtn").on("click", function () {
    $("#register").hide();
    $("#registerUsername1").val("");
    $("#registerUsername2").val("");
    $("#registerPass1").val("");
    $("#registerPass2").val("");
    $("#login").show();
  });



  // Register tooltip
  $("#registerTooltipBtn").on("click", function () {
    $("#login").hide();
    $("#loginUsername").val("");
    $("#loginPass").val("");
    $("#register").show();
  });



  // Personal cabinet page
  $("#cabinetCard").on("click", function () {
    $("#home").hide();
    $("#cabinet").show();
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_cabinet.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#cabinetResponseDiv").html(response);
      }
    });
  });



  $("#day0").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day0").css("color", "#9068be");
      $("#label_day0").css("font-weight", "bold");
    } else {
      $("#label_day0").css("color", "silver");
      $("#label_day0").css("font-weight", "normal");
    }
  });
  $("#day1").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day1").css("color", "#9068be");
      $("#label_day1").css("font-weight", "bold");
    } else {
      $("#label_day1").css("color", "silver");
      $("#label_day1").css("font-weight", "normal");
    }
  });
  $("#day2").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day2").css("color", "#9068be");
      $("#label_day2").css("font-weight", "bold");
    } else {
      $("#label_day2").css("color", "silver");
      $("#label_day2").css("font-weight", "normal");
    }
  });
  $("#day3").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day3").css("color", "#9068be");
      $("#label_day3").css("font-weight", "bold");
    } else {
      $("#label_day3").css("color", "silver");
      $("#label_day3").css("font-weight", "normal");
    }
  });
  $("#day4").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day4").css("color", "#9068be");
      $("#label_day4").css("font-weight", "bold");
    } else {
      $("#label_day4").css("color", "silver");
      $("#label_day4").css("font-weight", "normal");
    }
  });
  $("#day5").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day5").css("color", "#9068be");
      $("#label_day5").css("font-weight", "bold");
    } else {
      $("#label_day5").css("color", "silver");
      $("#label_day5").css("font-weight", "normal");
    }
  });
  $("#day6").on("click", function () {
    if ($(this).is(":checked")) {
      $("#label_day6").css("color", "#9068be");
      $("#label_day6").css("font-weight", "bold");
    } else {
      $("#label_day6").css("color", "silver");
      $("#label_day6").css("font-weight", "normal");
    }
  });



  $("#addTimesBtn").on("click", function () {
    if ($("#mednotiftime2").is(":disabled")) {
      $("#mednotiftime2").prop("disabled", false);
      $("#mednotiftime2").show();
      $("#removeTimesBtn").show();
    } else if ($("#mednotiftime3").is(":disabled")) {
      $("#mednotiftime3").prop("disabled", false);
      $("#mednotiftime3").show();
    } else if ($("#mednotiftime4").is(":disabled")) {
      $("#mednotiftime4").prop("disabled", false);
      $("#mednotiftime4").show();
    } else if ($("#mednotiftime5").is(":disabled")) {
      $("#mednotiftime5").prop("disabled", false);
      $("#mednotiftime5").show();
      $("#addTimesBtn").hide();
    }
  });



  $("#removeTimesBtn").on("click", function () {
    if ($("#mednotiftime5").is(":enabled")) {
      $("#mednotiftime5").prop("disabled", true);
      $("#mednotiftime5").hide();
      $("#addTimesBtn").show();
    } else if ($("#mednotiftime4").is(":enabled")) {
      $("#mednotiftime4").prop("disabled", true);
      $("#mednotiftime4").hide();
    } else if ($("#mednotiftime3").is(":enabled")) {
      $("#mednotiftime3").prop("disabled", true);
      $("#mednotiftime3").hide();
    } else if ($("#mednotiftime2").is(":enabled")) {
      $("#mednotiftime2").prop("disabled", true);
      $("#mednotiftime2").hide();
      $("#removeTimesBtn").hide();
    }
  });



  $("#setNotifBtn").on("click", function () {
    $("#mednotification").hide();
    $("#cabinet").show();
    var status = [];
    var days_arr = [];
    var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    var final_id_arr = [];
    var counter = 0;
    var notif_id_counter = 0;
    var times_arr = [$("#mednotiftime1").val(), $("#mednotiftime2").val(), $("#mednotiftime3").val(), $("#mednotiftime4").val(), $("#mednotiftime5").val()];

    for (var x = 0; x < times_arr.length; x++) {
      if ($("#mednotiftime" + (x + 1)).is(":disabled")) {
        times_arr[x] = " ";
      }
    }

    // Generates list of days checked by user
    for (var i = 0; i < 7; i++) {
      if ($("#day" + i).is(":checked")) {
        days_arr.push($("#label_day" + i).text());
      }
    }

    // Iterates through each day checked by user
    var dayflag = [0, 0, 0, 0, 0, 0, 0];
    for (var i = 0; i < days_arr.length; i++) {
      if (days_arr[i] == "Monday") {
        dayflag[0] = 1;
      } else if (days_arr[i] == "Tuesday") {
        dayflag[1] = 1;
      } else if (days_arr[i] == "Wednesday") {
        dayflag[2] = 1;
      } else if (days_arr[i] == "Thursday") {
        dayflag[3] = 1;
      } else if (days_arr[i] == "Friday") {
        dayflag[4] = 1;
      } else if (days_arr[i] == "Saturday") {
        dayflag[5] = 1;
      } else if (days_arr[i] == "Sunday") {
        dayflag[6] = 1;
      }
    }

    // Posts specific day with general time to server for notification creation
    $.ajax({
        type: "POST",
        async: false,
        url: "http://www2.cs.siu.edu/~mls/deploy/add_notif.php",
        data: {
          'userID': userAccNum_global,
          'medID': $("#medidForNotification").html(),
          'amount': $("#mednotifamount").val(),
          'notiftimes': JSON.stringify(times_arr),
          'dayflag': dayflag.join("")
        },
        dataType: "text"
      })
      // If day/time posting succeeds, proceed to refresh notifications for user
      .done(function (response) {
        status.push(response);
        if (response != "failure") {
          //console.log(response);
        }
        $.ajax({
            type: "POST",
            async: false,
            url: "http://www2.cs.siu.edu/~mls/deploy/refresh_notifs.php",
            data: {
              'userID': userAccNum_global
            },
            dataType: "json"
          })
          // If refresh succeeds, clear all notifications and create new notifications with SELECT * values
          .done(function (response) {
            console.log(counter);
            cordova.plugins.notification.local.clearAll(function () {

            }, this);

            var temp = response.toString();
            var separated = temp.split(",");
            console.log("Separated: " + separated);
            console.log(separated.length);
            for (var j = 0; j < separated.length; j++) {
              $.ajax({
                  type: "POST",
                  async: false,
                  url: "http://www2.cs.siu.edu/~mls/deploy/refresh_notif_times.php",
                  data: {
                    'userID': userAccNum_global,
                    'notifID': separated[j]
                  },
                  dataType: "json"
                })
                .done(function (response) {
                  var temp_time = response.toString();
                  var separated_time = temp_time.split(",");
                  for (var y = 0; y < separated_time.length; y++) {
                    if (separated_time[y].charAt(2) == ":") {
                      console.log("For loop: " + separated_time[y]);
                      console.log("Null check: " + separated_time[y].substring(0, 8));
                      var temp_hour = separated_time[y].substring(0, 2);
                      var temp_min = separated_time[y].substring(3, 5);
                      var temp_day = separated_time[y].substring(8, 15);
                      for (var w = 0; w < temp_day.length; w++) {
                        if (temp_day.charAt(w) == "1") {
                          var consolelogtemp = "Notif scheduled for " + weekdays[w] + " at " + temp_hour + ":" + temp_min + ", id:" + notif_id_counter;
                          console.log(consolelogtemp);
                          var msg = temp_hour + ":" + temp_min + " - Take " + separated_time[y].substring(15, 16) + " " + separated_time[y].substring(16, separated_time[y].length);
                          cordova.plugins.notification.local.schedule({
                            id: notif_id_counter,
                            title: "MLS",
                            text: msg,
                            trigger: {
                              count: 1,
                              every: {
                                weekday: parseInt(w + 1),
                                hour: parseInt(temp_hour),
                                minute: parseInt(temp_min)
                              }
                            }
                          });
                          notif_id_counter++;
                        }
                      }
                    }
                  }
                });
            }
            counter++;
          });
      });
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_cabinet.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#cabinetResponseDiv").html(response);
      }
    });
  });



  // Medicine search page
  $("#searchCard").on("click", function () {
    $("#home").hide('slide', {
      direction: 'left'
    }, 500);
    $("#search").show('slide', {
      direction: 'right'
    }, 500);
    $("#responseDiv").html(loader);
    $.ajax({
      type: "GET",
      url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
      dataType: "html",
      success: function (response) {
        $("#responseDiv").html(response);
      }
    });
  });



  // Group page
  $("#groupCard").on("click", function () {
    $("#home").hide();
    $("#groupnotif").show();
    $("body").css("background-color", "#fff");
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friendchats.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#userResponseDiv").html(response);
      }
    });
    //$("#grouptab_message_box").show();
    /*
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friends.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#friendsResponseDiv").html(response);
      }
    });
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friend_requests.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#requestsResponseDiv").html(response);
      }
    });
    */
  });


  $("#pharmacyCard").on("click", function () {
    $("#home").hide();
    $("#pharmacies").show();
  });



  // Return to home function
  $(".returnBtn").on("click", function () {
    $("body").css("background-color", "#e3e3e3");
    $("#cabinet").hide();
    $("#search").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#details").hide();
    $("#review").hide();
    $("#mednotification").hide();
    $("#accountsettings").hide();
    $("#accountsettings_edit").hide();
    $("#usersearchheader").hide();
    $("#grouptab_message_box").hide();
    $("#home").show();
  });

  $("#returnBtn_details").on("click", function () {
    $("#cabinet").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#details").hide();
    $("#home").hide();
    $("#search").show();
  });

  $("#returnBtn_chat").on("click", function () {
    $("#chatroom").hide();
    $("#chatResponseDiv").html("");
    $("#grouptab_message_box").hide();
    $("#groupnotif").show();
    clearInterval(chat_interval);
  });

  $("#returnBtn_review").on("click", function () {
    $("#cabinet").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#home").hide();
    $("#search").hide();
    $("#review").hide();
    $("#details").show();
  });

  $("#returnBtn_review_all").on("click", function () {
    $("#cabinet").hide();
    $("#groupnotif").hide();
    $("#pharmacies").hide();
    $("#home").hide();
    $("#search").hide();
    $("#review").hide();
    $("#review_all").hide();
    $("body").css("background-color", "#e3e3e3");
    $("#details").show();
  });




  $("#settingsCard").on("click", function () {
    $("body").css("background-color", "#fff");
    $("#home").hide();
    $("#accountsettings").show();
  });

  $("#edit_account").on("click", function () {
    $("#home").hide();
    $("#accountsettings").hide();
    $("#accountsettings_edit").show();
  });



  // Medicine search bar
  $("#medicine_magnify").on("click", function () {
    var str = $("#medSearchbar").val();
    if (str == "") {
      $("#responseDiv").html(loader);
      $.ajax({
        type: "GET",
        url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
        dataType: "html",
        success: function (response) {
          $("#responseDiv").html(response);
        }
      });
    } else {
      $("#responseDiv").html(loader);
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/search.php",
        data: {
          medSearchbar: str
        },
        success: function (response) {
          $("#responseDiv").html(response).show();
        }
      });
    }
  });







  $("#grouptab_message_submit").on("click", function () {
    if ($("#grouptab_message_text").val() != "") {
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/post_chat.php",
        data: {
          userID: userAccNum_global,
          friendID: friendAccNum_global,
          comment: $("#grouptab_message_text").val()
        },
        dataType: "html",
        success: function (response) {
          $("#grouptab_message_text").val("")
          $.ajax({
            type: "POST",
            url: "http://www2.cs.siu.edu/~mls/deploy/load_friendchats_messages.php",
            data: {
              'userID': userAccNum_global,
              'friendID': friendAccNum_global,
              'userName': friendName_global
            },
            dataType: "html",
            success: function (response) {
              $("#chatResponseDiv").html(response);
              var temp_div = $("#chatResponseDiv");
              temp_div.scrollTop(temp_div[0].scrollHeight - temp_div[0].clientHeight);
              //$("#chatResponseDiv").scrollTop($("#chatResponseDiv").scrollHeight);
            }
          });
        }
      });
    }
    //$("#chatResponseDiv").scrollTop($("#chatResponseDiv").scrollHeight);
  });

  $("#grouptab_message").on("click", function () {
    $("#userResponseDiv").html("");
    $("#usersearchheader").hide();
    $("body").css("background-color", "#fff");
    //$("#grouptab_message_box").show();
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friendchats.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#userResponseDiv").html(response);
      }
    });
    $("#grouptab_title").html("Instant Message");
    //$("#chatResponseDiv").scrollTop($("#chatResponseDiv").scrollHeight);
  });

  $("#grouptab_friends").on("click", function () {
    $("#userResponseDiv").html("");
    $("#usersearchheader").hide();
    $("#grouptab_message_box").hide();
    $("body").css("background-color", "#e3e3e3");
    $("#grouptab_title").html("My Friends");
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friends.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#userResponseDiv").html(response);
      }
    });
  });

  $("#grouptab_search").on("click", function () {
    $("#userResponseDiv").html("");
    $("#usersearchheader").show();
    $("#grouptab_message_box").hide();
    $("body").css("background-color", "#e3e3e3");
    $("#grouptab_title").html("User Search");
  });

  $("#grouptab_incoming").on("click", function () {
    $("#userResponseDiv").html("");
    $("#usersearchheader").hide();
    $("#grouptab_message_box").hide();
    $("body").css("background-color", "#e3e3e3");
    $("#grouptab_title").html("Incoming Requests");
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friend_requests_in.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#userResponseDiv").html(response);
      }
    });
  });

  $("#grouptab_outgoing").on("click", function () {
    $("#userResponseDiv").html("");
    $("#usersearchheader").hide();
    $("#grouptab_message_box").hide();
    $("body").css("background-color", "#e3e3e3");
    $("#grouptab_title").html("Outgoing Requests");
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friend_requests_out.php",
      data: {
        userID: userAccNum_global
      },
      dataType: "html",
      success: function (response) {
        $("#userResponseDiv").html(response);
      }
    });
  });




  // User search bar
  $("#userSearchbar").keyup(function () {
    var userID = userAccNum_global;
    console.log(userID);
    var str = $("#userSearchbar").val();
    if (str == "") {
      $("#userResponseDiv").html("");
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: str,
          userID: userID
        },
        dataType: "html",
        success: function (response) {
          $("#userResponseDiv").html(response);
        }
      });
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/load_friends.php",
        data: {
          userID: userAccNum_global
        },
        dataType: "html",
        success: function (response) {
          $("#friendsResponseDiv").html(response);
        }
      });
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/load_friend_requests.php",
        data: {
          userID: userAccNum_global
        },
        dataType: "html",
        success: function (response) {
          $("#requestsResponseDiv").html(response);
        }
      });
    } else {
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: str,
          userID: userID
        },
        success: function (response) {
          $("#userResponseDiv").html(response).show();
        }
      });
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/load_friends.php",
        data: {
          userID: userAccNum_global
        },
        dataType: "html",
        success: function (response) {
          $("#friendsResponseDiv").html(response);
        }
      });
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/load_friend_requests.php",
        data: {
          userID: userAccNum_global
        },
        dataType: "html",
        success: function (response) {
          $("#requestsResponseDiv").html(response);
        }
      });
    }
  });




  $("#submitReplyToReview_btn").on("click", function () {
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/post_review_reply.php",
      data: {
        'userID': userAccNum_global,
        'reviewID': review_id_global,
        'comment': $("#submitReplyToReview_text").val()
      },
      success: function (response) {
        //$("#responseDiv").html(response).show();
        $("#submitReplyToReview_div").hide();
        $("#submitReplyToReview_text").val("");
        $.ajax({
          type: "POST",
          url: "http://www2.cs.siu.edu/~mls/deploy/medDetails_reviews_all.php",
          data: {
            'medID': $("#idForReview").html()
          },
          dataType: "html",
          success: function (response) {
            $("#reviewAllResponseDiv").html(response);
          }
        });
      }
    });
  });





  $("#editaccount_save").on("click", function () {
    var temp_firstname = $("#editaccount_firstname").val();
    var temp_lastname = $("#editaccount_lastname").val();
    var temp_username = $("#editaccount_username").val();
    var temp_password = $("#editaccount_password").val();
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/app_editaccount.php",
      data: {
        'userID': userAccNum_global,
        'editFirst': temp_firstname,
        'editLast': temp_lastname,
        'editUsername': temp_username,
        'editPass': temp_password
      },
      success: function (response) {
        alert("Account settings updated.");
        $("body").css("background-color", "#e3e3e3");
        $("#cabinet").hide();
        $("#search").hide();
        $("#groupnotif").hide();
        $("#pharmacies").hide();
        $("#details").hide();
        $("#review").hide();
        $("#mednotification").hide();
        $("#accountsettings").hide();
        $("#accountsettings_edit").hide();
        $("#usersearchheader").hide();
        $("#grouptab_message_box").hide();
        $("#home").show();
      }
    });
  });










  function pushNotif(notif_id, notif_title, notif_text, notif_weekday, notif_hour, notif_minute) {
    cordova.plugins.notification.local.schedule({
      id: notif_id,
      title: notif_title,
      text: notif_text,
      trigger: {
        every: {
          weekday: notif_weekday,
          hour: notif_hour,
          minute: notif_minute
        }
      }
    });
  }


  /* Old function used for sending notifs via SMS */
  function textSender() {
    var number = "6182048500";
    var message = "\'Username\' is scheduled to take Ambien at 10:30 AM. Remind them!\n- The MLS Team";

    var options = {
      replaceLineBreaks: false,
      android: {
        intent: ''
      }
    }

    var success = function () {
      alert("Success");
    };
    var error = function (e) {
      alert("Failure: " + e);
    };
    sms.send(number, message, options, success, error);
  }



  function checkSMSPermission() {
    var success = function (hasPermission) {
      if (hasPermission) {
        textSender();
      } else {
        requestSMSPermission();
      }
    };
    var error = function (e) {
      alert("Something went wrong: " + e);
    };
    sms.hasPermission(success, error);
  }



  function requestSMSPermission() {
    var success = function (hasPermission) {
      if (!hasPermission) {
        sms.requestPermission(function () {
          console.log("Permission accepted");
          textSender();
        }, function (error) {
          console.info("Permission not accepted");
        })
      }
    };
    var error = function (e) {
      alert("Something went wrong: " + e);
    };
    sms.hasPermission(success, error);
  }



});