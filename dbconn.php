<?php

// connect to the database
$db = new mysqli('localhost', 'root', '', 'mess');

if($db->connect_error)
{
    die("Connection failed: " . $db->connect_error);
}

function run_sql_queries($db,$query)
{
    $backtrace =  debug_backtrace();
    $result = mysqli_query($db,$query);
    if (!$result) createLog(LogType::Error,$query, $backtrace, mysqli_error($db));   
    else createLog(LogType::Info,$query, $backtrace);
    
    return $result;
}

?>
