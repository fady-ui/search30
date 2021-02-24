<?php
//conection to database
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name="epiz_27995311_search";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully"; 
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}





if(isset($_POST['search'])){
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

    $stmt=$conn->prepare("SELECT * FROM users WHERE Name LIKE '%$searchq%' OR ID LIKE '%$searchq%'");
    $stmt->execute();
    $count=$stmt->rowCount();
    

    $out=' ';
    
    if($count >0){
          while($row=$stmt->fetch()){
            $name = $row['Name'];
            $id = $row['ID'];
    
            $out .='<div class="alert alert-success text-center test">'. $id . ' ' . $name.'</div>';
          }
       
    }else{
        $out = '<div class="alert alert-success text-center test">there was no member</div> ';
        
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="search.css">
    <title>search</title>
   </head>
    <body>
        <h1 class="text-center">Search Engine</h1>
        <form action="search.php" method="POST">
            <div class="col-md-4 text-center">
                <div class="input-group has-validation search">
                    <input type="text" class="form-control fsearch" name="search" id="validationCustomUsername" aria-describedby="inputGroupPrepend" placeholder="Search" >
                    <input class="btn btn-danger" type="submit" value="Search">
                </div>
            </div>
        </form>

        <?php
            if(!empty($out)){
                    print_r("$out"); 
                 }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </body>
</html>