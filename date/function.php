<?php 

function getCurrentDate()
{
    $rawDate = time();

    $processedDate = date('d-m-Y H:i', $rawDate);

    return $processedDate;
}
?>