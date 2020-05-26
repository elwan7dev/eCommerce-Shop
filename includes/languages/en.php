<?php

function lang($phrase)
{
    static $lang = array(
        // dashboard page
        'HOME' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEMS' => 'Items',
        'MEMBERS' => 'Members',
        'COMMENTS' => 'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS' => 'Logs',
        'PROFILE' => 'Edit Profile',
        'SETTING' => 'Setting',
        'LOGOUT' => 'Logout',
        'SEARCH' => 'Search',

        // setting page
    );
    return $lang[$phrase];
}
