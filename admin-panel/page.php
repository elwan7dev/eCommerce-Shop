<?php

/** #016 - Split Page With Get Request
 * 
 * Categories => [ manage | edit | update | add | insert | delete | stats ]
 * 
 * 
 * http://localhost/eCommerce/admin-panel/page.php?action=stats
 * 
 * 
 * condition ? true :  false 
 * 
 */

$action =  isset($_GET['action']) ? $_GET['action'] : 'manage' ;

// $action = '';
// if (isset($_GET['action'])) {
//     $action = $_GET['action'];

// } else {
//     echo 'manage';
// }


switch ($action) {
    case 'manage':
        echo 'Welcome in manage page';
        break;
    case 'add':
        echo 'Welcome in add page';
        break;
    case 'edit':
        echo 'Welcome in edit page';
        break;
    case 'stats':
        echo 'Welcome in stats page';
        break;
    case 'update':
        echo 'Welcome in update page';
        break;
    default:
        echo 'Error 404 : This page not found';
        break;
}
