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

use Illuminate\Database\Eloquent\Model;
use App\Models\AppGlobals;

/**
 * Description of Users
 *
 * @author Pranata  
 * 
 * @property int         $user_indx int(11) UNIQUE KEY AUTO_INCREMENT,
 * @property string     $user_key varchar(60) PRIMARY KEY,
 * @property string     $user_fname varchar(100) DEFAULT NULL,
 * @property string     $user_mname varchar(100) DEFAULT NULL,
 * @property string     $user_lname varchar(100) DEFAULT NULL,
 * @property string     $user_email varchar(100) DEFAULT NULL,
 * @property double    $user_phone double DEFAULT NULL,
 * @property double    $user_mobile double DEFAULT NULL,
 * @property string     $user_gender varchar(60) DEFAULT NULL,
 * @property string     $user_login_name varchar(60),
 * @property int         $user_status int(11) DEFAULT NULL,
 * @property string     $user_role varchar(60) DEFAULT NULL,
 * @property string     $user_verified varchar(60) DEFAULT NULL,
 * @property string     $user_email_vrified varchar(60) DEFAULT NULL,
 * @property string     $user_email_token text DEFAULT NULL,
 * @property string     $user_image text DEFAULT NULL,
 * @property string     $user_permissions longtext,
 * @property string     $user_create_date datetime DEFAULT CURRENT_TIMESTAMP,
 * @property string     $user_update_date datetime DEFAULT CURRENT_TIMESTAMP,
 * @property string     $user_password text DEFAULT NULL,
 * @property string     $user_remarks longtext NOT NULL,
 * @property int         $user_otp int(11) DEFAULT NULL,
 * @property string     $user_delete enum('Y', 'N') DEFAULT 'N' 
 * 
 */
class Users extends Model {

    const type_none = "none";
    const type_photo_video = "photo_video";
    const type_compose_online = "compose_online";
    const type_mixed = "mixed";
    //-----------
    const publish_immediately = "1";
    const publish_later = "2";

    /**
     * The table associated with the model.
     *
     * @var string
     * 
     */
    protected $table = 'tbl_users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_key';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function name() {
        $name = "";

        $name .= ($this->user_fname != null && strlen($this->user_fname)) ? $this->user_fname . " " : "";
        $name .= ($this->user_mname != null && strlen($this->user_mname)) ? $this->user_mname . " " : "";
        $name .= ($this->user_lname != null && strlen($this->user_lname)) ? $this->user_lname : "";

        return $name;
    }

    public function status_text() {
        switch ($this->user_status) {
            case AppGlobals::active : return "Active";
            case AppGlobals::inactive: return "Inactive";
            default: return "";
        }
    }

    public function get_params($with = []) {
        $data = [];

        foreach ($this->attributesToArray() as $key => $value) {
            $index = str_replace('user_', "", $key);

            if ($index !== 'delete')
                $data[ $index ] = $value;
        }

        $data[ 'name' ] = $this->name();
        $data[ 'status_text' ] = $this->status_text();
        $data[ 'create_date2' ] = AppGlobals::getDate($this->user_create_date);
        $data[ 'update_date2' ] = AppGlobals::getDate($this->user_update_date);
        $data[ 'permissions' ] = ($this->user_permissions != null && strlen($this->user_permissions)) ? json_decode($this->user_permissions) : [];

        return $data;
    }
}
