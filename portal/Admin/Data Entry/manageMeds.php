<html>
    <head>
        <title>Administrator Portal</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">
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
                               <a class="nav-link" href="index.html">Dashboard <span class="sr-only">(current)</span></a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">Settings</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">Help</a>
                           </li>
                       </ul>
                       <span class="navbar-text" id="adminName">Doe, John 012345</span>
                   </div>
                </nav>
            </div>
            
            
            <!--Side navigation bar-->
            <div class="side-nav">
                <div class="sidenav">
                    <a>View All</a>
                    <a>Add</a>
                    <a>Remove</a>
                    <a>Ban</a>
                    
                </div>
            </div>
            
            <!---Main content--->
            <div class="main">
                
                <!--Start table--->
                <table class="table table-hover medTable">
                    <thead>
                        <tr>
                            <th id="medName">Name</th>
                            <th id="medDosage">Dosage</th>
                            <th id="medBanned">Banned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 


                        $conn = mysql_connect("local_host", "root", "", "company");
                        if($conn->connect_error) {
                            die("Connection failed:" .$conn-> connect_error);
                            }
                        $sql = "SELECT med_name, dosage, banned from Medicines"
                        $result = $conn->query($sql);

                        if ($result) -> numrows > 0){
                            while($row = $result -> fetch_assoc()){
                                echo "<tr><td>" . $row["med_name"] . "</td><td>" . $row["dosage"] . "</td><td>" . $row["banned"] . "</td></tr>";
                                }
                            echo "</table>";
                        }
                        else {
                            echo "0 result";
                        }
                        $conn-> close();
                        ?>
                   
                </table>
                
                
            </div>
            
            
        </div>
    </body>
</html>