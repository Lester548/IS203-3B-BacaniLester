<?php

require('./database.php');

$querryAccounts = "SELECT * FROM services";
$sqlAccounts = mysqli_query($connection, $querryAccounts);

?>