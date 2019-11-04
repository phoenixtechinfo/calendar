
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        html,body{
            margin: 0px;
            padding: 0px;
        }
        div.row_data{
            padding-top: 20px;
        }

        h1.privacy_h1{
            font-family: corbel;
            font-size: 30px;
            font-weight: 600;
            text-decoration: underline;
            padding-bottom: 10px;
        }

        p.privacy_p{
            font-family: corbel;
            font-size: 15px;
            font-weight: 600;
            text-align: justify;
        }

        h1.policy_h1{
            font-family: corbel;
            font-size: 20px;
            font-weight: 600;
        }

        ul.b{
            list-style-type: square;
            font-family: corbel;
            font-size: 15px;
            font-weight: 600;
            text-align: justify;
        }

        li.li_view{
            padding: 2px;
            position: relative;
            right: 20px;
        }
        .container{
            overflow-x: hidden;
        }
    </style>
    </head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 row_data">
            <h1 class="privacy_h1">{{$title}}</h1>
            <p class="privacy_p">
                <?php
                echo $content;
                ?>
            </p>
        </div>
    </div>

</div>
</body>
</html>