<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src = js/vue.js></script>

    <title>upload_price</title>
</head>
<body>
    <div class="container" id="main_upload_file">
        <div class="row">
          <header class="text-center"><h2> страница загрузки нового прайса </h2></header>
        </div>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">прайсы
                    <li class="list-group-tem"
                        v-for="price in files_price"> {{price.name}} date:{{price.date}}
                    </li>
                </ul>       
            </div>
            <div class="col-md-6">
                <form action="upload_file.php" method="post" enctype="multipart/form-date">
                    <input type = "file" class="btn btn-info" name="upload_price">
                    <input type = "submit" class="btn btn-primary" value="загрузить новый прайс" >
                </form>
            </div>   
        </div>
    </div>
        <div class="row">
        <?php 
            $uploaded_file = '/uploadFiles/price.csv' 
        ?>  
        </div>
        <script type = 'text/javascript' src='js/upload_file.js'></script>
</body>
</html>


