<?php

function lang($phrase)
{
    static $lang = array(
         // dashboard page
         'HOME' => 'الرئيسية',
         'CATEGORIES' => 'الأصناف',
         'PROFILE' => 'الحساب',
         'SETTING' => 'الاعدادات',
         'LOGOUT' => 'تسجيل الخروج',
         'SEARCH' => 'بحث'
 

    );
    return $lang[$phrase];
}
