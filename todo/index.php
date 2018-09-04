<?php
  
    if(isset($_POST['dark'])){
        setcookie('dark', '#000', time() + -1);
        header('Location: index.php');
    }

    

// host infos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="js/js.js"></script>
    <title>Document</title>
</head>
<body>

    <!-- -->
    <div id="header"></div>

    <!-- button to add a a task! -->
    <button id="add_new" onclick="add_one()" >
        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
    </button>

    <!-- colors -->
    <div id="container_colors">
        <form method="post">
            <input type="submit" name="dark" id="black" value="">
            <input type="submit" name="light" id="gray" value="">
            <input type="submit" name="yellow" id="yellow" value="">
            <!-- MORE COLORS!
            <input type="submit" name="red" id="red" value="">
            <input type="submit" name="blue" id="blue" value="">
            <input type="submit" name="green" id="green" value=""> 
            -->
    </div>

    <?php
    #SET COOKIES 
        if(isset($_POST['dark'])){
            setcookie('yellow', '#000', time() + -1);
            setcookie('dark', '#000', time() + 365*24*3600);
           
            header('Location: index.php');
        }
        
        if(isset($_POST['light'])){
            #TO DELETE THE DARK & THE YELLOW COOKIES (the default theme)
            setcookie('dark', '#000', time() + -1);
            setcookie('yellow', '#000', time() + -1);
            header('Location: index.php');
        }

        if(isset($_POST['yellow'])){
            #TO DELETE THE DARK COOKIE
            setcookie('dark', '#000', time() + -1);
            #SET NEW COOKIE
            setcookie('yellow', '#000', time() + 365*24*3600);
            header('Location: index.php');
        }

        # IF THE COOKIE EXIST CHANGE COLORS 

        if(isset($_COOKIE['dark'])){
            echo "
            <style type='text/css'>
                body{
                    background-color: #2c3e50;
                    color: white;
                }
                #header{
                    background-color: black;
                }
                #container{
                    background-color: #546263;
                }
                #add_new{
                    background-color: #3498db;
                }
                fieldset{
                    border: 1px solid #3498db;
                }
            </style>";
        }

        if(isset($_COOKIE['yellow'])){
            echo "
            <style type='text/css'>
                body{
                    background-color: #ecf0f1;
                    color: #d35400;
                }
                #header{
                    background-color: #f39c12;
                }
                #container{
                    background-color: #fff46f;
                }
                #add_new{
                    background-color: #d35400;
                }
                fieldset{
                    border: 1px solid #d35400;
                }
            </style>";
        }

    ?>

    <!-- adding task (not displaying till you click on button "add_new") -->
    <div id="add_todo">
        <h2>A new task!</h2>
            <input type="text" name="title" placeholder="Title :" class="add_title"/>
            <textarea name="todo" class="input" rows="18" placeholder="What to do!"></textarea>
            <input type="submit" name="send_todo" class="sendtodo" value="Save"> 
            <input type="submit" name="exit" class="none" value="Exit"> 
        
    </div>


    <?php
        // if updating a task clicked!
        if(isset($_GET['id_upt'])){
          
            $req = "SELECT * FROM caseone WHERE id=$_GET[id_upt]";
            $sql = mysqli_query($conn, $req);
            $aff = mysqli_fetch_assoc($sql);

            // to display the upload division
            echo "
            <style type='text/css'>
            #update_todo{
                width: 705px;
                height: 400px;
                background-color: white;
                margin: auto;
                position: absolute;
                margin-left: auto;
                margin-right: auto;
                left: 0;
                right: 0;
                padding: 20px;
                display: block;
                margin-top: -60px;
                box-shadow: 0px 0px 33px -14px black;
            }
            </style>


            <div id='update_todo'>
            <h2>Update a task!</h2>
            <form method='post'>
                <input type='text' name='up_title' placeholder='Title :' class='add_title' value='$aff[title_do]'/>
                <textarea name='up_todo' class='input' rows='18' >$aff[text_do]</textarea>
                <input type='submit' name='send_update' class='sendtodo' value='Save'> 
                <input type='submit' name='exit' class='none' value='Exit'> 
            </form>
        </div>

            ";
            
            // exit (redirection to the index)
            if(isset($_POST['exit'])){
                header('Location: index.php');
            }

            //updating
            if(isset($_POST['send_update'])){
                $up_title = $_POST['up_title'];
                $up_text = $_POST['up_todo'];
           
            $sql = "UPDATE caseone SET title_do='$up_title', text_do='$up_text' WHERE id=$_GET[id_upt]";
            
            mysqli_query($conn, $sql);
            mysqli_close($conn);

            header('Location: index.php');  
            }


        }
   
        // adding a task!
        if(isset($_POST['send_todo'])){
           
                $title = $_POST['title'];
                $texto = $_POST['todo'];
           
            $sql = "INSERT INTO caseone ( title_do, text_do) VALUES ( '$title', '$texto')";

        mysqli_query($conn, $sql);
 
        }
    ?>

      
    <div id="container">
    <?php
        // this bring all the infos from the BDD.
        $req = "SELECT * FROM caseone";
        $sql = mysqli_query($conn, $req);
        while($aff = mysqli_fetch_assoc($sql)){
            $id_sup = $aff['id'];
            $id_update = $aff['id'];
            echo"
            <div id='container_do'>
                <fieldset>
                    <legend><h4 style='margin: 0;'  >$aff[title_do]</h4></legend>
                    $aff[text_do]
                </fieldset>
                
                <div id='delete' class='delup'><a href='urls.php?nom=$id_sup'><i class='fa fa-trash-o' aria-hidden='true' id='delete_butt'></i>
                <span class='sr-only'></span></a></div>

                <div id='update' class='delup' ><a href='index.php?id_upt=$id_update'><i class='fa fa-pencil fa-fw' id='upload_butt'></i>
                <span class='sr-only'></span></a></div>
                
            </div>
            ";
        }
        
        mysqli_close($conn);
    ?> 
        
    </div>
    </form>
</body>
</html>