<?php 
    require_once('../../db.php');
    
    try {
        $goalId = intval($_POST['goal_id']); 
        $typeId = intval($_POST['type_id']);
        $goalName = trim($_POST['goal_name']);
        $targetDate = date('Y-m-d', strtotime($_POST['target_date']));
        $targetAmount = floatval($_POST['target_amount']);
        $savedAmount = floatval($_POST['saved_amount']);
        $statusId = intval($_POST['status_id']);
        
        $lastModified = date('Y-m-d H:i:s');
    
        if (empty($goalName) || empty($targetAmount)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        if (empty($_POST['target_date']) || !strtotime($_POST['target_date'])) {
            $_SESSION['error'] = 'Въведете валидна целева дата.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        if (!is_numeric($targetAmount) || $targetAmount < 0) {
            $_SESSION['error'] = 'Въведете валидна целева сума.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        if ($savedAmount > $targetAmount) {
            $_SESSION['error'] = 'Спестената сума не може да бъде по-голяма от целевата сума.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        if (!is_numeric($savedAmount) || $savedAmount < 0) {
            $_SESSION['error'] = 'Въведете валидна спестена сума.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        $stmt = $pdo->prepare('
            SELECT 
                goal_name,
                goal_type_id,
                target_amount,
                saved_amount,
                target_date,
                status_id
            FROM 
                financial_goals
            WHERE 
                goal_id = :goal_id
        ');
        $stmt->execute([':goal_id' => $goalId]);
        $goal = $stmt->fetch();

        // converting the fields to the same type as the ones in the database
        $dbGoalName = trim($goal['goal_name']);
        $dbTypeId = intval($goal['goal_type_id']);
        $dbTargetAmount = floatval($goal['target_amount']);
        $dbSavedAmount = floatval($goal['saved_amount']);
        $dbTargetDate = date('Y-m-d', strtotime($goal['target_date']));
        $dbStatusId = intval($goal['status_id']);

        if (
            $dbGoalName === $goalName &&
            $dbTypeId === $typeId &&
            $dbTargetAmount === $targetAmount &&
            $dbSavedAmount === $savedAmount &&
            $dbTargetDate === $targetDate &&
            $dbStatusId === $statusId
        ) {
            // Няма промени
            $_SESSION['error'] = 'Няма направени промени.';
            header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        $stmt = $pdo->prepare('
            UPDATE financial_goals 
            SET 
                goal_name = :goal_name,
                goal_type_id = :goal_type_id,
                target_amount = :target_amount,
                saved_amount = :saved_amount,
                target_date = :target_date,
                status_id = :status_id,
                last_modified = :last_modified
            WHERE 
                goal_id = :goal_id
        ');
    
        $stmt->execute([
            ':goal_name' => $goalName,
            ':goal_type_id' => $typeId,
            ':target_amount' => $targetAmount,
            ':saved_amount' => $savedAmount,
            ':target_date' => $targetDate,
            ':status_id' => $statusId,
            ':last_modified' => $lastModified,
            ':goal_id' => $goalId,
        ]);
    
        $_SESSION['success'] = 'Целта беше успешно актуализирана.';
        header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Грешка при актуализация: ' . $e->getMessage();
        header('Location: ../../?page=finance-goals&action=edit&id=' . $goalId);
        exit;
    }
    
?>