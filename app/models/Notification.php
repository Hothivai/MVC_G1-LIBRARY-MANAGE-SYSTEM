<?php

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'title', 'message', 'type', 'is_read', 'created_at'];

    // Relationships and custom methods
}
