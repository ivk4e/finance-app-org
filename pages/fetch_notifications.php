<?php
require_once('../db.php');

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS upcoming_goals
            FROM financial_goals
            WHERE user_id = :user_id 
            AND status_id = 1 
            AND DATEDIFF(target_date, CURDATE()) BETWEEN 0 AND 5
        ");
        $stmt->execute([':user_id' => $user_id]);
        $upcoming_goals = $stmt->fetchColumn();

        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS upcoming_obligations
            FROM financial_liabilities
            WHERE user_id = :user_id 
            AND status_id = 1 
            AND DATEDIFF(target_date, CURDATE()) BETWEEN 0 AND 5
        ");
        $stmt->execute([':user_id' => $user_id]);
        $upcoming_obligations = $stmt->fetchColumn();

        echo json_encode([
            'upcoming_goals' => (int) $upcoming_goals,
            'upcoming_obligations' => (int) $upcoming_obligations
        ]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Грешка при извличането на данните.']);
    }
} else {
    echo json_encode(['error' => 'Потребителят не е логнат.']);
}
