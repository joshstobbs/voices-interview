<?php

function view(String $filename) {
    return require("views/{$filename}.php");
}

function partial(String $filename) {
    return require("partials/{$filename}.php");
}
