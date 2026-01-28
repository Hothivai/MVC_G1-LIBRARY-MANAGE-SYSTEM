<?php
namespace App\Models;

use App\Core\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function create($data)
    {
        $sql = "INSERT INTO notifications 
                (user_id, transaction_id, type, title, message)
                VALUES (:user_id, :transaction_id, :type, :title, :message)";
        return $this->db->query($sql, $data);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM notifications
                WHERE user_id = :user_id
                ORDER BY created_at DESC";
        return $this->db->query($sql, ['user_id' => $userId])->fetchAll();
    }

    public function countByUser($userId)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM notifications 
                WHERE user_id = :user_id";
        return $this->db->query($sql, ['user_id' => $userId])->fetch()['total'];
    }

    public function exists($userId, $transactionId, $type)
    {
        $sql = "SELECT notification_id FROM notifications
                WHERE user_id = :user_id 
                  AND transaction_id = :transaction_id
                  AND type = :type";
        return $this->db->query($sql, [
            'user_id' => $userId,
            'transaction_id' => $transactionId,
            'type' => $type
        ])->rowCount() > 0;
    }
}
