<?php
    // if ( 0 < $_FILES['file']['error'] ) {

    //     echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    // }
    //else {
    $path='/var/www/html/socialplus/assets/images/'.$_FILES['file']['name'];
        if(move_uploaded_file($_FILES['file']['tmp_name'],$path))
       		echo $path;
       	else
       		echo 0;
    //}
?>