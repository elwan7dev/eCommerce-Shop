<?php

function lang($phrase)
{
    static $lang = array(
        // Home page words
        'MESSAGE' => 'Welcome',
        'ADMIN' => 'Adminstrator'

        // setting page
    );
    return $lang[$phrase];
}
