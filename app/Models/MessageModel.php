<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    // Define the table associated with this model
    protected $table      = 'chat_messages';
    protected $primaryKey = 'id';

    // Define the fields that can be inserted/updated
    protected $allowedFields = ['sender_id', 'receiver_id', 'message'];

    // Use automatic timestamps for creation and update (optional)
    protected $useTimestamps = true;

    // Define validation rules (optional)
    protected $validationRules = [
        'sender_id'   => 'required|integer',
        'receiver_id' => 'required|integer',
        'message'     => 'required|string',
        'time'         => 'required|valid_date',
    ];

    // Define messages for validation (optional)
    protected $validationMessages = [
        'sender_id' => [
            'required' => 'The sender ID is required',
            'integer'  => 'The sender ID must be an integer',
        ],
        'receiver_id' => [
            'required' => 'The receiver ID is required',
            'integer'  => 'The receiver ID must be an integer',
        ],
        'message' => [
            'required' => 'The message is required',
        ],
        'time' => [
            'required' => 'The time is required',
            'valid_date' => 'The time must be a valid date',
        ]
    ];

    public function saveMessage($messageData)
    {
        return $this->insert($messageData);
    }
}
