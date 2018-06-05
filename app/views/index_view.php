<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@Shopify API</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/app.css" type="text/css">

</head>
<body>
<div class="container">
    <div class="row page-header">
        <div class="col">
            <h1 class="display-4">
                @Shopify API
                <a role="button" id="checkForNewData" class="btn btn-light reload-btn float-right">Оновити</a>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3 class="section-title">
                Колекції
            </h3>
            <div class="row">
                <div class="col" id="responseMessages">

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card-columns" id="collections-box">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3 class="section-title">
                Продукти
                <a role="button" class="btn btn-light float-right" id="displayAllProducts">Показати всі продукти</a>
            </h3>
            <div class="row">
                <div class="col">
                    <div class="card-columns" id="products-box">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="dist/js/app.js"></script>

</body>
</html>