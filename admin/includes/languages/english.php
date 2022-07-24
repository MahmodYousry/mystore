<?php

    function lang($phrase) {

        static $lang = array(

            //Navbar Links

            'HOME_ADMIN'    => 'Home',
            'CATEGORIES'    => 'Categories',
            'ITEMS'         => 'Items',
            'MEMBERS'       => 'Members',
            'COMMENTS'      => 'Comments',
            'STATISTICS'    => 'Statistics',
            'LOGS'          => 'Logs',
            'STATUS'        => 'Status',
            ''  => '',

        );

        return $lang[$phrase];

    }
