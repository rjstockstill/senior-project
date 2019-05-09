<?php

$connection = mysqli_connect('dbserv.cs.siu.edu', 'mls', 'pZR5i2ts', 'mls');

//Test Connect
if(mysqli_connect_errno()){
    echo 'DB connection error: ' .mysqli_connect_error();
}
