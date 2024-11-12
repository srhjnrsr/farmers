<?php

$homePage = 'home.html';

if (file_exists($homePage)) {

    header('Location: ' . $homePage);
    exit();
} else {

    echo 'Error: home.html file not found.';
}
