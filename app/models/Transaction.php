<?php

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id', 'book_id', 'borrow_date', 'return_date', 'due_date', 'status', 'notes'];

    // Relationships and custom methods
}
