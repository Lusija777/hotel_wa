<?php

session_start();
include('funkcie_vseobecne.php');

session_unset();
session_destroy();
redirect('/projekt/index.php');