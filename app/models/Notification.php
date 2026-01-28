<?php
require_once dirname(__DIR__) . '/core/Model.php';

class Notification extends Model
{
    protected $table = 'notifications';

    public function create($data)
    {
        $sql = "INSERT INTO notifications 
                (user_id, transaction_id, type, title, message)
                VALUES (:user_id, :transaction_id, :type, :title, :message)";
        $stmt = $this->db->query($sql);
        return $stmt->execute($data);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM notifications
                WHERE user_id = :user_id
                ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function countByUser($userId)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM notifications
                WHERE user_id = :user_id";
        $stmt = $this->db->query($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch()['total'];
    }

    public function exists($userId, $transactionId, $type)
    {
        $sql = "SELECT notification_id
                FROM notifications
                WHERE user_id = :user_id
                  AND transaction_id = :transaction_id
                  AND type = :type";
        $stmt = $this->db->query($sql);
        $stmt->execute([
            'user_id' => $userId,
            'transaction_id' => $transactionId,
            'type' => $type
        ]);
        return $stmt->rowCount() > 0;
    }
}
