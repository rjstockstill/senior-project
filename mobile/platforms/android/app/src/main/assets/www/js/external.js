/*
Functions referenced by inline CSS in HTML returned by server PHP.
*/



/**
 * Opens review page for a medicine.
 * @param {*} input 
 */
function openReviewForm(input) {
  $("#cabinet").hide();
  $("#search").hide();
  $("#groupnotif").hide();
  $("#pharmacies").hide();
  $("#details").hide();
  $("#review").show();
  $("#home").hide();
}

function editReviewForm(input) {
  //console.log(input);
  alert("UNDER CONSTRUCTION: Edit review")
}



/**
 * Opens details of a specific medicine.
 * @param {number} medid 
 * @param {string} name 
 * @param {string} general 
 * @param {string} manuf 
 */
function openMedDetails(medid, name, general, manuf) {
  $("#home").hide();
  $("#search").hide();
  $("body").css("background-color", "#e3e3e3");
  $("#details").show();

  $.ajax({
    type: "POST",
    async: false,
    url: "http://www2.cs.siu.edu/~mls/deploy/medDetails.php",
    data: {
      'userID': userAccNum_global,
      'medID': medid,
      'medName': name,
      'medGeneral': general,
      'medManuf': manuf
    },
    dataType: "html",
    success: function (response) {
      $("#detailResponseDiv").html(response);
      $.ajax({
        type: "POST",
        async: false,
        url: "http://www2.cs.siu.edu/~mls/deploy/medDetails_reviews.php",
        data: {
          'medID': medid,
          'medName': name,
          'medGeneral': general,
          'medManuf': manuf
        },
        dataType: "html",
        success: function (response) {
          $("#medReviewsDiv").html(response);
        }
      });
    }
  });
}



/**
 * Loads all user reviews for a specific medicine.
 * @param {number} medid 
 * @param {string} name 
 * @param {string} general 
 * @param {string} manuf 
 */
function loadAllReviews(medid) {
  $("#details").hide();
  $("#review_all").show();
  $("body").css("background-color", "#fff");
  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/medDetails_reviews_all.php",
    data: {
      'medID': medid
    },
    dataType: "html",
    success: function (response) {
      $("#reviewAllResponseDiv").html(response);
    }
  });
}



/**
 * Adds a specific medicine to user's cabinet.
 * @param {number} userid 
 * @param {number} medid 
 * @param {number} added 
 * @param {string} medname 
 * @param {string} medgeneral 
 * @param {string} medmanuf 
 */
function addMedicineToCabinet(userid, medid, added, medname, medgeneral, medmanuf) {
  if (added == 0) {
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/add_medicine.php",
      data: {
        'userID': userid,
        'medID': medid
      },
      dataType: "html",
      success: function (response) {
        alert("Added " + " to your cabinet!");
        $.ajax({
          type: "POST",
          url: "http://www2.cs.siu.edu/~mls/deploy/medDetails.php",
          data: {
            'userID': userAccNum_global,
            'medID': medid,
            'medName': medname,
            'medGeneral': medgeneral,
            'medManuf': medmanuf
          },
          dataType: "html",
          success: function (response) {
            $("#detailResponseDiv").html(response);
          }
        });
      }
    });
  } else {
    alert("This medicine is already in your cabinet! Open your cabinet if you want to remove it.");
  }
}



/**
 * Removes a specific medicine from user's cabinet.
 * @param {number} userid 
 * @param {number} medid 
 */
function removeFromCabinet(userid, medid) {
  console.log("removing");
  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/remove_medicine.php",
    data: {
      'userID': userid,
      'medID': medid
    },
    dataType: "html",
    success: function (response) {
      // clear all notifications and re-add here

      var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
      var notif_id_counter = 0;

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
                  if (separated_time[y].length > 7) {
                    console.log("For loop: " + separated_time[y]);
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

                    //var msg = temp_hour + ":" + temp_min + " - Take " + separated_time[y].substring(15, 16) + " " + separated_time[y].substring(16, separated_time[y].length);
                    /*
                    cordova.plugins.notification.local.schedule({
                      id: parseInt(separated[j]),
                      title: "MLS",
                      text: msg,
                      trigger: {
                        count: 1,
                        every: {
                          weekday: parseInt(temp_day),
                          hour: parseInt(temp_hour),
                          minute: parseInt(temp_min)
                        }
                      }
                    });
                    */
                  }
                }
              });
          }
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
      alert("Removed medicine from your cabinet");
    }
  });
}



/**
 * Opens noficiation setter form.
 * @param {number} userid 
 * @param {number} medid 
 */
function addToNotifications(userid, medid) {
  $("#cabinet").hide();
  $("#mednotification").show();
  $("#medidForNotification").html(medid);
}



/**
 * Deletes a cabinet medicine's notifications.
 * @param {number} userid 
 * @param {number} medid 
 */
function removeFromNotifications(userid, medid) {
  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/remove_notif.php",
    data: {
      'userID': userid,
      'medID': medid
    },
    dataType: "html",
    success: function (response) {
      // clear all notifications and re-add here

      var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
      var notif_id_counter = 0;

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
                  if (separated_time[y].length > 7) {
                    console.log("For loop: " + separated_time[y]);
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

                    //var msg = temp_hour + ":" + temp_min + " - Take " + separated_time[y].substring(15, 16) + " " + separated_time[y].substring(16, separated_time[y].length + 1);
                    /*
                    cordova.plugins.notification.local.schedule({
                      id: parseInt(separated[j]),
                      title: "MLS",
                      text: msg,
                      trigger: {
                        count: 1,
                        every: {
                          weekday: parseInt(temp_day),
                          hour: parseInt(temp_hour),
                          minute: parseInt(temp_min)
                        }
                      }
                    });
                    */
                  }
                }
              });
          }
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
      alert("Removed medicine from your notifications");
    }
  });
}



/**
 * Adds a user's medicine notification to a friend's device.
 * @param {number} userid 
 * @param {number} medid 
 * @param {number} amount 
 * @param {string} time1 
 * @param {string} time2 
 * @param {string} time3 
 * @param {string} time4 
 * @param {string} time5 
 * @param {number} dayflag 
 */
function addToGroupNotifications(userid, medid, amount, time1, time2, time3, time4, time5, dayflag) {
  var tester = userid + " " + medid + " " + amount + " " + time1 + " " + time2 + " " + time3 + " " + time4 + " " + time5 + " " + dayflag;
  var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
  var notif_id_counter = 0;
  console.log(tester);
  $.ajax({
    type: "POST",
    async: false,
    url: "http://www2.cs.siu.edu/~mls/deploy/add_group_notif.php",
    data: {
      'userID': userid,
      'medID': medid,
      'amount': amount,
      'time1': time1,
      'time2': time2,
      'time3': time3,
      'time4': time4,
      'time5': time5,
      'dayflag': dayflag,
      'notif_enabled': 1
    },
    dataType: "text",
    success: function (response) {

      /* BEGIN NEW CODE INSERTED FROM INDIVIDUAL NOTIFS (MAY NOT WORK) */
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
      /* END NEW CODE INSERTED FROM INDIVIDUAL NOTIFS (MAY NOT WORK) */














      // clear all notifications and re-add here

      /*
      var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
      var notif_id_counter = 0;

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
          //cordova.plugins.notification.local.clearAll(function () {

          //}, this);

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
                  if (separated_time[y].length > 7) {
                    console.log("For loop: " + separated_time[y]);
                    var temp_hour = separated_time[y].substring(0, 2);
                    var temp_min = separated_time[y].substring(3, 5);
                    var temp_day = separated_time[y].substring(8, 15);
                    for (var w = 0; w < temp_day.length; w++) {
                      if (temp_day.charAt(w) == "1") {
                        var consolelogtemp = "Notif scheduled for " + weekdays[w] + " at " + temp_hour + ":" + temp_min + ", id:" + notif_id_counter;
                        console.log(consolelogtemp);
                        notif_id_counter++;
                      }
                    }
                    //cordova.plugins.notification.local.schedule({
                    //  id: parseInt(separated[j]),
                    //  title: "MLS Notification",
                    //  text: consolelogtemp,
                    //  trigger: {
                    //    count: 1,
                    //    every: {
                    //      weekday: parseInt(temp_day),
                    //      hour: parseInt(temp_hour),
                    //      minute: parseInt(temp_min)
                    //    }
                    //  }
                    //});
                  }
                }
              });
          }
        });
        */


      alert("Added group notification!");
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

    }
  });
}



/**
 * Removes a user's medicine notification from a friend's device.
 * @param {number} userid 
 * @param {number} medid 
 */
function removeFromGroupNotifications(userid, medid) {
  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/remove_group_notif.php",
    data: {
      'userID': userid,
      'medID': medid
    },
    dataType: "html",
    success: function (response) {


      /* MORE COPIED CODE */
      var weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
      var notif_id_counter = 0;

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
                  if (separated_time[y].length > 7) {
                    console.log("For loop: " + separated_time[y]);
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

                    //var msg = temp_hour + ":" + temp_min + " - Take " + separated_time[y].substring(15, 16) + " " + separated_time[y].substring(16, separated_time[y].length + 1);
                    /*
                    cordova.plugins.notification.local.schedule({
                      id: parseInt(separated[j]),
                      title: "MLS",
                      text: msg,
                      trigger: {
                        count: 1,
                        every: {
                          weekday: parseInt(temp_day),
                          hour: parseInt(temp_hour),
                          minute: parseInt(temp_min)
                        }
                      }
                    });
                    */
                  }
                }
              });
          }
        });
      /* MORE COPIED CODE */








      // clear all notifications and re-add here
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
      alert("Removed medicine from your notifications");
    }
  });
}









function openChat(userID, userName) {
  $("#groupnotif").hide();
  $("#chatroom").show();
  $("#grouptab_message_box").show();
  $("#chat_friendname").html(userName);
  friendAccNum_global = userID;
  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/load_friendchats_messages.php",
    data: {
      'userID': userAccNum_global,
      'friendID': userID,
      'userName': userName
    },
    dataType: "html",
    success: function (response) {
      $("#chatResponseDiv").html(response);
      var temp_div = $("#chatResponseDiv");
      temp_div.scrollTop(temp_div[0].scrollHeight - temp_div[0].clientHeight);
    }
  });

  chat_interval = setInterval(function () {
    $.ajax({
      type: "POST",
      url: "http://www2.cs.siu.edu/~mls/deploy/load_friendchats_messages.php",
      data: {
        'userID': userAccNum_global,
        'friendID': userID,
        'userName': userName
      },
      dataType: "html",
      success: function (response) {
        $("#chatResponseDiv").html(response);
      }
    });
    console.log('checked');
  }, 1000);
}









/**
 * Adds a friend to a user's friend list.
 * @param {number} uid 
 * @param {string} uname 
 */
function addFriend(uid, uname) {
  var senderID = userAccNum_global;
  var receiverID = uid;

  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/add_friend.php",
    data: {
      'senderID': senderID,
      'receiverID': receiverID
    },
    dataType: "html",
    success: function (response) {
      alert("Friend request sent to " + uname);
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: "",
          userID: userAccNum_global
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
    }
  });
}



/**
 * Removes a friend from a user's friend list.
 * @param {number} uid 
 * @param {string} uname 
 */
function removeFriend(uid, uname) {
  var senderID = userAccNum_global;
  var receiverID = uid;

  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/remove_friend.php",
    data: {
      'senderID': senderID,
      'receiverID': receiverID
    },
    dataType: "html",
    success: function (response) {
      alert("You have removed " + uname + " from your friends list");
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: "",
          userID: userAccNum_global
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
    }
  });
}



/**
 * Approves another user's request to be friends with a user.
 * @param {number} uid 
 * @param {string} uname 
 */
function approveRequest(uid, uname) {
  var senderID = userAccNum_global;
  var receiverID = uid;

  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/approve_friend.php",
    data: {
      'senderID': senderID,
      'receiverID': receiverID
    },
    dataType: "html",
    success: function (response) {
      alert(uname + "'s request has been accepted");
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: "",
          userID: userAccNum_global
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
    }
  });
}



/**
 * Removes another user's request to be friends with a user.
 * @param {number} uid 
 * @param {string} uname 
 */
function removeRequest(uid, uname) {
  var senderID = userAccNum_global;
  var receiverID = uid;

  $.ajax({
    type: "POST",
    url: "http://www2.cs.siu.edu/~mls/deploy/remove_request.php",
    data: {
      'senderID': senderID,
      'receiverID': receiverID
    },
    dataType: "html",
    success: function (response) {
      alert(uname + "'s request has been deleted");
      $.ajax({
        type: "POST",
        url: "http://www2.cs.siu.edu/~mls/deploy/userSearch.php",
        data: {
          userSearchbar: "",
          userID: userAccNum_global
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
    }
  });
}



// Docs
function changeCol(item) {
  if ($(item).html() == "Like") {
    console.log("Liked");
    $(item).html("Liked");
    $(item).css("color", "deepskyblue");
  } else {
    console.log("Unliked");
    $(item).html("Like");
    $(item).css("color", "silver");
  }
}



function replyToReview(review_id, username) {
  //console.log(review_id);
  var placeholder_str = "Reply to " + username + "...";
  $("#submitReplyToReview_text").attr("placeholder", placeholder_str);
  $("#submitReplyToReview_div").show();
  review_id_global = review_id;
}