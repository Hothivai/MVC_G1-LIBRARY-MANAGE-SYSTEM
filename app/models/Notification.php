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

    // ================= EXISTS TODAY =================
    /**
     * Kiểm tra xem đã có thông báo được tạo hôm nay chưa
     */
    public function existsToday(int $userId, int $transactionId, string $type): bool
    {
        $sql = "SELECT notification_id
                FROM notifications
                WHERE user_id = ?
                  AND transaction_id = ?
                  AND type = ?
                  AND DATE(created_at) = CURDATE()";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $transactionId, $type]);

        return $stmt->rowCount() > 0;
    }

    // ================= CHECK AND CREATE REMINDERS =================
    /**
     * Kiểm tra và tạo thông báo nhắc nhở trả sách trước 1 ngày
     * Kiểm tra và tạo thông báo khi quá hạn
     */
    public function checkAndCreateReminders(int $userId): void
    {
        $sql = "
            SELECT 
                t.transaction_id,
                t.due_date,
                b.title AS book_title,
                DATEDIFF(t.due_date, CURDATE()) AS days_until_due,
                DATEDIFF(CURDATE(), t.due_date) AS days_overdue
            FROM transactions t
            JOIN book_copies bc ON t.copy_id = bc.copy_id
            JOIN books b ON bc.book_id = b.book_id
            WHERE t.user_id = ?
              AND t.return_date IS NULL
              AND t.status IN ('borrowed', 'overdue')
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($transactions as $transaction) {
            $transactionId = $transaction['transaction_id'];
            $daysUntilDue = (int)$transaction['days_until_due'];
            $daysOverdue = (int)$transaction['days_overdue'];
            $bookTitle = $transaction['book_title'];

            // Kiểm tra và tạo thông báo quá hạn
            if ($daysOverdue > 0) {
                // Tạo thông báo mới mỗi ngày để cập nhật số ngày quá hạn mới nhất
                if (!$this->existsToday($userId, $transactionId, 'overdue')) {
                    $this->create([
                        'user_id' => $userId,
                        'transaction_id' => $transactionId,
                        'type' => 'overdue',
                        'title' => 'The book is overdue',
                        'message' => "You are {$daysOverdue} days overdue. Please return the book '{$bookTitle}' immediately."
                    ]);
                }
            }
            // Kiểm tra và tạo thông báo nhắc nhở trước 1 ngày
            elseif ($daysUntilDue == 1) {
                // Chỉ tạo thông báo nếu chưa có thông báo nhắc nhở cho transaction này
                if (!$this->exists($userId, $transactionId, 'reminder')) {
                    $this->create([
                        'user_id' => $userId,
                        'transaction_id' => $transactionId,
                        'type' => 'reminder',
                        'title' => 'Reminder to return the book',
                        'message' => "The book '{$bookTitle}' of yours is due tomorrow. Please prepare to return it."
                    ]);
                }
            }
        }
    }
}
