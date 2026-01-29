<?php
require_once dirname(__DIR__) . '/core/Model.php';

class Notification extends Model
{
    protected string $table = 'notifications';

    // ================= CREATE =================
    public function create(array $data): bool
    {
        $sql = "INSERT INTO notifications
                (user_id, transaction_id, type, title, message)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['user_id'],
            $data['transaction_id'],
            $data['type'],
            $data['title'],
            $data['message']
        ]);
    }

    // ================= GET BY USER =================
    public function getByUser(int $userId): array
    {
        $sql = "SELECT *
                FROM notifications
                WHERE user_id = ?
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= COUNT =================
    public function countByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM notifications
                WHERE user_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // ================= EXISTS =================
    public function exists(int $userId, int $transactionId, string $type): bool
    {
        $sql = "SELECT notification_id
                FROM notifications
                WHERE user_id = ?
                  AND transaction_id = ?
                  AND type = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $transactionId, $type]);

        return $stmt->rowCount() > 0;
    }
}
