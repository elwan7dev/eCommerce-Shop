<?php

function getTitle()
{
    global $pageTitle; // VIP: before this line func doesn't work

    if (isset($pageTitle)) {
        echo $pageTitle;
    }else {
        echo 'title';
    }
}