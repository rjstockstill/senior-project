<?php 
    include '../../db.php'; 
    session_start();
?>

<?php
    $query = "SELECT * from UserAccount";
    $message = mysqli_query($connection, $query);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        
        <title>Register | MLS</title>
        
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h3>Medication Leaflet System</h3>
                <hr>
                <h4>Register User</h4>
            </div>
            
            <div class="register-container-left" id="msg">
            
            <form enctype="multipart/form-data" method="post" action="success.php" class="register-patient" id="registrationForm" onsubmit = "return(validate());" name="registrationForm">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <select id="accountType" name="type" class="form-control" onchange="viewDocFile()">
                            <option value="head" required>Account Type</option>
                            <option value="doctor" >Doctor</option>
                            <option value="regular">Regular Account</option>
                        </select>
                    </div>
                    
              
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        *This row required for doctors only
                        <input type="text" placeholder="License Number" name="licenseNumber">
                               
                    </div>
                    <div class="form-group col-md-7">
                        Upload Photo Identification: <input type="file" name="photoID" id="photoID" >
                             
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="email" class="form-control" name="email" placeholder="E-Mail" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type=password class="form-control" name="password" placeholder="Password (7 character min)" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-sm-6">
                      
                      <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                    </div>
                    
                    <div class="form-group col-sm-6">
                      <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                    </div>
                  </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <select id="gender" class="form-control">
                            <option required>Gender</option>
                            <option value="Male" id="male" name="male">Male</option>
                            <option value="Female" id="female" name="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-2">
                        <select name="selectMonth" id="birthMonth" name="birthMonth" class="form-control">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April<option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>  
                        </select>
                </div>
                
                    
                    <div class="form-group col-md-1">
                        <select name= "selectDay" id="birthDay" class="form-control">
                            <option value="01">1</option>       
                            <option value="02">2</option>       
                            <option value="03">3</option>       
                            <option value="04">4</option>       
                            <option value="05">5</option>       
                            <option value="06">6</option>       a
                            <option value="07">7</option>       
                            <option value="08">8</option>       
                            <option value="09">9</option>       
                            <option value="10">10</option>       
                            <option value="11">11</option>       
                            <option value="12">12</option>       
                            <option value="13">13</option>       
                            <option value="14">14</option>       
                            <option value="15">15</option>       
                            <option value="16">16</option>       
                            <option value="17">17</option>       
                            <option value="18">18</option>       
                            <option value="19">19</option>       
                            <option value="20">20</option>       
                            <option value="21">21</option>       
                            <option value="22">22</option>       
                            <option value="23">23</option>       
                            <option value="24">24</option>       
                            <option value="25">25</option>       
                            <option value="26">26</option>       
                            <option value="27">27</option>       
                            <option value="28">28</option>       
                            <option value="29">29</option>       
                            <option value="30">30</option>       
                            <option value="31">31</option>  
                        </select>
                </div>
                <div class="form-group col-md-2">
                    <select name="birthYear" class="form-control" id="birthYear"> 
                            <option value="1913">1913</option>
                            <option value="1914">1914</option>
                            <option value="1915">1915</option>
                            <option value="1916">1916</option>
                            <option value="1917">1917</option>
                            <option value="1918">1918</option>
                            <option value="1919">1919</option>
                            <option value="1920">1920</option>
                            <option value="1921">1921</option>
                            <option value="1922">1922</option>       
                            <option value="1923">1923</option>       
                            <option value="1924">1924</option>       
                            <option value="1925">1925</option>       
                            <option value="1926">1926</option>       
                            <option value="1927">1927</option>       
                            <option value="1928">1928</option>       
                            <option value="1929">1929</option>       
                            <option value="1930">1930</option>       
                            <option value="1931">1931</option>     
                            <option value="1932">1932</option>
                            <option value="1933">1933</option>
                            <option value="1934">1934</option>
                            <option value="1935">1935</option>
                            <option value="1936">1936</option>
                            <option value="1937">1937</option>
                            <option value="1938">1938</option>
                            <option value="1939">1939</option>
                            <option value="1940">1940</option>
                            <option value="1941">1941</option>       
                            <option value="1942">1942</option>       
                            <option value="1943">1943</option>
                            <option value="1944">1944</option>
                            <option value="1945">1945</option>
                            <option value="1946">1946</option>
                            <option value="1947">1947</option>
                            <option value="1948">1948</option>
                            <option value="1949">1949</option>
                            <option value="1950">1950</option>
                            <option value="1951">1951</option>
                            <option value="1952">1952</option>       
                            <option value="1953">1953</option>       
                            <option value="1954">1954</option>       
                            <option value="1955">1955</option>       
                            <option value="1956">1956</option>       
                            <option value="1957">1957</option>       
                            <option value="1958">1958</option>       
                            <option value="1959">1959</option>       
                            <option value="1960">1960</option>       
                            <option value="1961">1961</option>     
                            <option value="1962">1962</option>
                            <option value="1963">1963</option>
                            <option value="1964">1964</option>
                            <option value="1965">1965</option>
                            <option value="1966">1966</option>
                            <option value="1967">1967</option>
                            <option value="1968">1968</option>
                            <option value="1969">1969</option>
                            <option value="1970">1970</option>
                            <option value="1971">1971</option>       
                            <option value="1972">1972</option>       
                            <option value="1973">1973</option>       
                            <option value="1974">1974</option>       
                            <option value="1975">1975</option>       
                            <option value="1976">1976</option>       
                            <option value="1977">1977</option>       
                            <option value="1978">1978</option>       
                            <option value="1979">1979</option>       
                            <option value="1980">1980</option>       
                            <option value="1981">1981</option>
                            <option value="1982">1982</option>
                            <option value="1983">1983</option>
                            <option value="1984">1984</option>
                            <option value="1985">1985</option>
                            <option value="1986">1986</option>
                            <option value="1987">1987</option>
                            <option value="1988">1988</option>
                            <option value="1989">1989</option>
                            <option value="1990">1990</option>       
                            <option value="1991">1991</option>       
                            <option value="1992">1992</option>       
                            <option value="1993">1993</option>       
                            <option value="1994">1994</option>       
                            <option value="1995">1995</option>       
                            <option value="1996">1996</option>       
                            <option value="1997">1997</option>       
                            <option value="1998">1998</option>       
                            <option value="1999">1999</option>     
                            <option value="2000">2000</option>
                            <option value="2001">2001</option>
                            <option value="2002">2002</option>
                            <option value="2003">2003</option>
                            <option value="2004">2004</option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                            <option value="2007">2007</option>
                            <option value="2008">2008</option>
                            <option value="2009">2009</option>       
                            <option value="2010">2010</option>       
                            <option value="2011">2011</option>       
                            <option value="2012">2012</option>       
                            <option value="2013">2013</option>       
                            <option value="2014">2014</option>       
                            <option value="2015">2015</option>       
                            <option value="2016">2016</option>       
                            <option value="2017">2017</option>       
                            <option value="2018">2018</option> 
                            <option value="2019">2019</option> 
                        </select> 
                    </div>
                    
                    <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="weight" placeholder="Weight">
                  </div>
                    <div class="form-group col-md-1">
                        <select id="weightType" name="weightType" class="form-control">
                            <option value="lbs">lbs</option>
                            <option value="kg">kg</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" name="height" placeholder="Height (in)">
                    </div>
                    
                
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <input type="text" class="form-control" id="inputAddress" placeholder="Address 1" name="address1" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="inputAddress2" name="address2" placeholder="Address 2">
                  </div>
                    
              
                    <div class="form-group col-md-4">
                      <input type="text" name="city" class="form-control" id="inputCity" placeholder="City" required>
                    </div>
                    <div class="form-group col-md-2">
                      <select id="inputState" name="state" class="form-control" required>
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
                      <input type="text" class="form-control" name="zip" id="inputZip" placeholder="ZIP" required>
                    </div>
                  </div>
                <div class="form-row">
                    
                    
                </div>
                <div class="form-row">
                    <div class="form-group button register">
                    <button type="submit" name="submit" class="btn button">Register User</button>
                  </div>
                    <div class="form-group button register">
                    <button type="reset" class="btn button">Reset</button>
                  </div>
                </div>
                  
                  </form>
            </div>
        
        <div class="register-container-right">
            
        </div>
        </div>
    <script type="text/javascript">
        
            /*
            Function works for the console but is not working for the showing/hiding of div
            */
        
        function viewDocFile() {
            var licensefile = document.getElementById("doclicense");
            var accountType = document.getElementById('accountType').value;
            if (accountType === 'regular' || accountType === 'head') {
                licensefile.style.display = "none"; 
                console.log(type);
            } else { 
                licensefile.style.display = "block";
                console.log(type);
                }
            }
        
        function validate() {
            
        if( document.registrationForm.zip.value == "" || isNaN( document.registrationForm.zip.value ) ||
            document.registrationForm.zip.value.length != 5 ) {
                alert( "Please provide a zip in the format #####." );
                document.registrationForm.zip.focus() ;
                return false;
            }
        }
        
        if( document.registrationForm.password.value == "" ||
            document.registrationForm.password.value.length < 7 ) {
                alert( "Password must be at least 7 characters." );
                document.registrationForm.password.focus() ;
                return false;
            }
        }
        
    </script>
    </body>
    
</html>
