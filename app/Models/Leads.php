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
use App\Models\Users;

/**
 * Description of Leads
 *
 * @author Pranata
 * 
 * @property int     $lead_indx                 Auto-incremented unique index
 * @property string $lead_id                    Primary key (varchar 60)
 * @property string $lead_email              Email of the lead
 * @property int     $lead_phone              Phone number
 * @property string $lead_enquiry_for      What the enquiry is for
 * @property string $lead_type                Type of lead
 * @property string $lead_status             Status of the lead
 * @property string $lead_given_date      Date given (as string)
 * @property string $lead_user_id           Related user id
 * @property string $lead_create_date     Created timestamp
 * @property string $lead_update_date    Updated timestamp
 * @property string $lead_delete             Soft delete flag ('Y' or 'N')
 * 
 * @property Users      $users Description
 * 
 */
class Leads extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_leads';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'lead_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
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

    /**
     * 
     * @return Users
     */
    public function user() {
        return $this->belongsTo(Users::class, "lead_user_id", "user_key");
    }

    /**
     * Get structured attributes for frontend/API.
     *
     * @return array
     */
    public function get_params() {
        $data = [];

        foreach ($this->attributesToArray() as $key => $value) {
            $index = str_replace('lead_', '', $key);

            if ($index !== 'delete') {
                $data[ $index ] = $value;
            }
        }

        $data[ 'user' ] = [];

        if ($this->users != null) {
            $data[ 'user' ] = $this->users->get_params();
        }

        $data[ 'create_date2' ] = AppGlobals::getDate($this->lead_create_date);
        $data[ 'update_date2' ] = AppGlobals::getDate($this->lead_update_date);

        return $data;
    }
}
