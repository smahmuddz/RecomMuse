<?php
    session_start();
    include "head.php";
    include "database.php";
?>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<div>
    <div class="content">
        <div class="content__container">
            <p class="content__container__text">
            Music
            </p>
            
            <ul class="content__container__list">
                <li class="content__container__list__item">Recommended</li>
                <li class="content__container__list__item">Personalized</li>
                <li class="content__container__list__item">Feed</li>
                <li class="content__container__list__item">For you</li>
            </ul>
        </div>
    </div>
</div>
</html>
