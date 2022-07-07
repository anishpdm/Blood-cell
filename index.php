<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="background: red">

    <nav class="navbar navbar-expand-sm bg-success navbar-dark">
        <ul class="navbar-nav">

            <li class="nav-item active">
                <a class="nav-link" href="cancerpredict.php">Blood cell count </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">LogOut</a>
            </li>

        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col col-sm-2">


            </div>

            <div class="col col-sm-8 col-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="table">
                        <tr>
                            <td></td>
                            <td>
                                <h4> Bloodcell Image </h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Upload Blood Cell image </td>
                            <td>
                                <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                            </td>
                        </tr>


                        <tr>
                            <td></td>
                            <td><button class="btn btn-success" name="but" type="submit">CHECK</button></td>
                        </tr>

                        <br>
                        <br>


                        <tr>
                            <td></td>
                            <td>

                            </td>
                        </tr>




                    </table>
                </form>

            </div>


            <div class="col col-sm-2">


            </div>


        </div>

    </div>

</body>

</html>



<?php
include './db.php';
if (isset($_POST["but"])) {

    $target_dir = "uploads/";
    $target_file = $target_dir . "testimage.jpg";

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "File Uploaded Succesfully";

        $res = file_get_contents("http://127.0.0.1:4000/predict");
        $obj = json_decode($res);
        $rbc = $obj->{'rbc'};
        $wbc = $obj->{'wbc'};
        echo "<center> <p class='text-light'> Red Blood cell count : $rbc   </p> </center> <br>";
        echo "<center><p class='text-light'> White Blood cell count : $wbc </p> </center> <br> ";
        echo "<center><p class='text-light'> Image </p> </center> <br> ";

        echo "<img src='op.jpg' />";

    }


}


?>
