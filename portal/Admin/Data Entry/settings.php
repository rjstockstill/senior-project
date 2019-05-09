<?php include '../../db.php'; 

    session_start();
    $myusername = $_SESSION['user'];
?>

<?php
    
    $type = gettype($myusername);

    if($type == "string"){
        $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userName = ?");
        $namequery -> bind_param("s", $myusername);
        $namequery -> execute();
        $namequery->store_result();
        
        if($namequery->num_rows>0){
            $namequery->bind_result($firstname, $lastname);
            $namequery->fetch();
            $namequery->close();
            
      
        }   else{
            echo "Could not find that row...";
        }
    }   else if($type="integer"){
            $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userAcc_id = ?");
            $namequery -> bind_param("i", $myusername);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($firstname, $lastname);
                $namequery->fetch();
                $namequery->close();


            }   else{
                echo "Could not find that row...";
            }
        
    }
                                       
    
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Data Entry Settings | MLS</title>
    </head>
    <body>
        <div class="container">
            
            <!--Top navigation bar-->
            <div class="nav">
                <nav class="navbar navbar-expand-lg ">
                   <a class="navbar-brand" href="#">Medication Leaflet System</a>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                       <span class="navbar-toggler-icon"></span>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarText">
                       <ul class="navbar-nav mr-auto">
                           <li class="nav-item">
                               <a class="nav-link" href="index.php">Dashboard <span class="sr-only">(current)</span></a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="settings.php">Settings</a>
                           </li>
                           
                       </ul>
                       <div class="username">
                    <a href="settings.php"><?php 
                        
                        echo  "$lastname, $firstname"; ?></a>
            </div>
            <div class="logout-text">
                Logout
            </div>
                       <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
                        
                     
                   </div>
                </nav>
            </div>
            
            <div class="main-settings">
            
          
                <h2>Edit Personal Information</h2>
                <hr>
                
                <form action="update.php" method="post">
                    
                      <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="address1" placeholder="Address">
                      </div>
                      <div class="form-group">
                        <label for="inputAddress2">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="Apartment, studio, or floor">
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">City</label>
                          <input type="text" name="city" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputState">State</label>
                          <select id="inputState" name="state" class="form-control">
                            <option selected>State</option>
                                  <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                        </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputZip">Zip</label>
                              <input type="text" name="zip" class="form-control" id="inputZip">
                            </div>
                          </div>
                    <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">Current Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="currentPW" placeholder="Current Password">
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">New Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="newPW" placeholder="New Password">
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">Confirm Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="confirmPW" placeholder="Confirm Password">
                             </div>
                         </div>
                    <div class="text-center">
                          <input class="update-submit"  type="submit" name="submit" value="Save Changes" style="align-contents:center">
                    </div>
                        </form>


                           
        </div>
        </div>
    </body>
</html>