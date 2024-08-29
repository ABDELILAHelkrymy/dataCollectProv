<?php

$role = $_SESSION['userrole'] ?? null;
var_dump($role);
if ($role === 'sg_gouv') {
    header('Location: /dashboard');
    exit;
} else{
        header('Location: /dataCollect');
        exit;
}