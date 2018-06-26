<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * ApprovalAction Model
 *
 * @category Models
 * @license  Proprietary and confidential
 */
class ApprovalAction extends Model
{
    protected $table = 'approval_actions';

    protected $fillable = [
        'approval_request_id',
        'approval_action_type_id',
        'note',
        'documents'
    ];

    /**
     * Request
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function request() : HasOne
    {
        return $this->hasOne('App\ApprovalRequest', 'id', 'approval_request_id');
    }

    /**
     * Action Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function action_type() : HasOne
    {
        return $this->hasOne('App\ApprovalActionType', 'id', 'approval_action_type_id');
    }
}
