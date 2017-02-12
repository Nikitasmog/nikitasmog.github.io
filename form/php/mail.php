<?php

$recepient = "admin@vanweb.ru";
$sitename = "vanweb";

$name = trim($_POST["cd-name"]);
$phone = trim($_POST["cd-company"]);
$email = trim($_POST["cd-email"]);
$message = trim($_POST["cd-textarea"]);
$message = "Имя: $name \nТелефон: $phone \nПочта: $email \nТекст: $message";

$pagetitle = "Новый запись с сайта \"$sitename\"";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");