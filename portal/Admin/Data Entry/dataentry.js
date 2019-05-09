/*eslint-env browser*/
/*jslint node: true */
"use strict";

var user = document.getElementById("hiddenUser");
var med = document.getElementById("hiddenMedicine");
var overview = document.getElementById("hiddenOverview");
var review = document.getElementById("hiddenReviews");
var medform = document.getElementById("add-med-form");

document.getElementById('block-button').addEventListener('click', function () {
    document.querySelector('.block-modal').style.display = 'flex';
});
            
/* eslint-disable */
function showMed() {
    if (med.style.display === "none") {
        med.style.display = "block";
        user.style.display = "none";
        overview.style.display = "none";
        review.style.display = "none";
        medform.style.display = "none";
    } else {
        med.style.display = "none";
    }
}
            
function showUser() {
    if (user.style.display === "none") {
        user.style.display = "block";
        med.style.display = "none";
        overview.style.display = "none";
        review.style.display = "none";
        medform.style.display = "none";
    } else {
        user.style.display = "none";
    }
}

function showReviews() {
    if (review.style.display === "none") {
        review.style.display = "block";
        med.style.display = "none";
        overview.style.display = "none";
        user.style.display = "none";
        medform.style.display = "none";
    } else {
        review.style.display = "none";
    }
}
            
function showOverview() {
    if (overview.style.display === "none") {
        overview.style.display = "block";
        med.style.display = "none";
        user.style.display = "none";
        review.style.display = "none";
        medform.style.display = "none";
    } else {
        overview.style.display = "none";
    }
}

function showMedForm() {
    if (medform.style.display === "none") {
        medform.style.display = "block";
    } else {
        medform.style.display = "none";
    }
}