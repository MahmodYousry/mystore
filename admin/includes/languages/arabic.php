<?php

    function lang(  $phrase ) {

        static $lang = array(

            //Homepage

            'MESSAGE' => 'Welcome in arabic',
            'ADMIN' => 'arabic admin'

        );

        return $lang[$phrase];

    }