<?php

/*
 *  To change this license header, choose License Headers in Project Properties.
 *  To change this template file, choose Tools | Templates
 *  and open the template in the editor.

 *  Licensed to the Apache Software Foundation (ASF) under one or more
 *  contributor license agreements. See the NOTICE file distributed with
 *  this work for additional information regarding copyright ownership.
 *  The ASF licenses this file to You under the Apache License, Version 2.0
 *  (the "License"); you may not use this file except in compliance with
 *  the License. You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 * 
 *  Developer: Pranata Naskar (pranata.naskar@gmail.com)
 *  
 * 
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Description of AppGlobals
 *
 * @author Pranata
 */
class AppGlobals {

    const active = 1;
    const inactive = 2;
    const draft = 3;
    const archive = 4;
    //--------------
    const Yes = "Y";
    const No = "N";
    //--------------    
    const user_key = "user_key";
    const user_name = "user_name";
    const user_username = "user_username";
    const user_time = "user_time";
    //---------------   
    const CART_MIN_TOTAL = 2500; //999
    const SHIPPING_COST = 0;
    //-----
    const delete_no = 1; //N
    const delete_yes = 2; //Y
    //------------
    const adm_theme = 'admthm';

    //put your code here

    public static function autoKey(\Illuminate\Database\Eloquent\Model $model = null) {
        if ($model != null) {
            $columns = Schema::getColumnListing($model->getTable());
            $prefix = $last_indx = '';
            $table = null;

            if (!empty($columns)) {
                $prefix = str_replace("indx", "", $columns[ 0 ]);
            }

            if ($prefix != '')
                $table = DB::table($model->getTable())->orderBy("{$prefix}indx", 'DESC')->first();

            $last_indx = ($table != null) ? $table->{"{$prefix}indx"} + 1 : 1;
            $last_indx = str_pad($last_indx, '5', '0', STR_PAD_LEFT);

            return $last_indx;
        }

        return date('YmdHis', time()) . rand(111, 999);
    }

    public static function invoice() {
        return 'IN' . date('YmdHis', time()) . rand(111, 999);
    }

    public static function reset_password_otp() {
        return rand(111111, 999999);
    }

    public static function getToday($format = 'Y-m-d') {
        return date("{$format}");
    }

    public static function getTime($format = 'H:i:s') {
        return date("{$format}");
    }

    public static function getDate($date, $format = 'j M, Y h:i A') {
        return date("{$format}", strtotime($date));
    }

    public static function create_slug($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     * @param type $time time() + 60 * 60 * 24 * 30;
     * @return boolean
     */
    public static function set_cookie($name, $value, $time = null) {
        if ($time == null)
            $time = time() + 60 * 60 * 24 * 30;

        return setcookie(trim($name), trim($value), $time);
    }

    /**
     * 
     * @param type $name
     * @return boolean
     */
    public static function has_cookie($name) {
        if (isset($_COOKIE[ $name ]))
            return TRUE;

        return FALSE;
    }

    /**
     * 
     * @param type $name
     * @return mixed
     */
    public static function get_cookie($name = '') {
        if ($name !== '')
            return $_COOKIE[ $name ];

        return $_COOKIE;
    }

    /**
     * 
     * @param type $name
     * @return boolean
     */
    public static function unset_cookie($name = '') {
        if ($name == '') {
            // unset cookies
            if (isset($_SERVER[ 'HTTP_COOKIE' ])) {
                $cookies = explode(';', $_SERVER[ 'HTTP_COOKIE' ]);
                foreach ($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[ 0 ]);
                    setcookie($name, '', time() - 1000);
                    setcookie($name, '', time() - 1000, '/');
                }
            }
        } else {
            setcookie($name, '', time() - 1000);
        }

        return true;
    }

    public static function convert_currency($from, $to) {
        $url = "https://wise.com/in/currency-converter/{$from}-to-{$to}-rate";
        $data = file_get_contents($url);
        //print_r($data);
        preg_match("/<span class=\"text-success\">(.*)<\/span>/", $data, $converted);

        //print_r($converted);
        if (is_array($converted) && !empty($converted)) {
            return (isset($converted[ 1 ])) ? $converted[ 1 ] : 1;
        }

        return 1;
    }

    /**
     * 
     * @param int $count
     * @param string $format
     * @return type
     */
    public static function getPrevMonths($count = 1, $format = 'M-Y') {
        $today = self::getToday();
        $tempArray = [];
        $count = 12;
        $tempArray[] = date("{$format}", strtotime($today));

        for ($ii = 1; $ii <= $count; $ii++) {
            $tempArray[] = date("{$format}", strtotime("{$today} -{$ii} month"));
        }

        return $tempArray;
    }

    /**
     * 
     * @param type $status
     * @return string
     */
    public static function status_text($status) {
        switch ($status) {
            case self::active: return 'Active';
            case self::inactive: return 'Inactive';
            case self::draft: return 'Draft';
            case self::archive: return 'Archive';
            default: return'';
        }
    }
}
