$(document).ready(function () {

  window.isphone = false;
  if (document.URL.indexOf("http://") === -1 && document.URL.indexOf("https://") === -1) {
    window.isphone = true;
  }

  if (window.isphone) {
    document.addEventListener("deviceready", onDeviceReady, false);
  } else {
    onDeviceReady();
  }




});

function onDeviceReady() {
}