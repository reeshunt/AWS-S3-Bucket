<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Upload file</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <form action="uploads3.php" method="post" enctype="multipart/form-data">
                <h2 style="text-align:center">Upload Files For Animal Drawing</h2>
                <label for="file_name">Upload Image:</label>
                <input type="file" name="uploadfile" id="uploadfile"></br>
                <label for="rename_file">Asset Name:</label></br>
                <input type="text" name="rename_file" placeholder="Enter Asset name"></br></br>
                <input class="btn btn-success" type="submit" name="submit" value="Upload">
                <p><b>Note:</b><i class='text-danger'>Only .jpg, .jpeg, .gif, .png, .mp4 formats are allowed to a max size of 5 MB.</i> </p>
            </form>
        </div>
    </body>
</html>