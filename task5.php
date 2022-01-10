<?php

$errors = [];

function UplaodPic()
{
    if (!empty($_FILES['image']['name'])) {
        $ImageName = $_FILES['image']['name'];
        $imageTemp = $_FILES['image']['tmp_name'];
        $imageExt = explode('.', $ImageName);
        $finalExt = trim(strtolower(end($imageExt)));
        $allowedExt = ['gif', 'jgp', 'png'];
        if (in_array($finalExt, $allowedExt)) {
            $finalname = rand() . time() . '.' . $finalExt;
            $distnationFolder = './uploads/' . $finalname;
            if (move_uploaded_file($imageTemp, $distnationFolder)) {
                return $distnationFolder;
            } else {
                $errors['whileUpload'] = 'Upload faild please try again'; // pass Error
            }
        } else {

            $errors['formatnotAllowed'] = 'Selected Format Not allowed'; // pass Error
        }
    } else {
        global $errors;
        $errors['emptyImage'] = 'Image Field Is Requird';                // pass Error
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $errors;
    $title =  strip_tags($_POST['title']);
    $content = strip_tags($_POST['content']);
    $imageUrl = UplaodPic();
    if (empty($title)) {
        $errors['EmptyTitle'] = 'Title Field Requird';
    }
    if (!is_string($title)) {
        $errors['strName'] = 'only Alphabets allowed';
    }

    if (!empty($content)) {
        if (strlen($content) < 50) {
            $errors['shortContent'] = 'Content Field most contains 50 Chars at least';
        }
    } else {
        $errors['EmptyContent'] = 'Content Field Requird';
    }

    if (count($errors) > 0) {
        foreach ($errors as $key => $value) {
            echo '<b> * : ' . $key . ' | ' . $value . '<b><br>';
        }
    } else {
        $file = fopen('text.txt', 'a') or die('Faild');
        fwrite($file,"\n". $title. ',' .$content . ',' .$imageUrl);
        fclose($file);
      
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title></title>
</head>

<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group" >
                <label for="title"><b>Title : </b></label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="form-group">
                <label for="conte"><b>Content : </b></label>
                <input type="text" name="content" class="form-control">
            </div>
            <div class="form-group">
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit">اضــافة</button>
        </form>
    </div>
</body>

</html>