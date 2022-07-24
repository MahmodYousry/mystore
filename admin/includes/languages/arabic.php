<?php

    function lang(  $phrase ) {

        static $lang = array(

            //Homepage

            'HOME_ADMIN'    => 'الرئيسيه',
            'CATEGORIES'    => 'الفئات',
            'ITEMS'         => 'المنتجات',
            'MEMBERS'       => 'الاعضاء',
            'COMMENTS'      => 'الكومنتات',
            'STATISTICS'    => 'Statistics',
            'LOGS'          => 'Logs',
            'STATUS'        => 'الحاله',
            ''  => '',

        );

        return $lang[$phrase];

    }