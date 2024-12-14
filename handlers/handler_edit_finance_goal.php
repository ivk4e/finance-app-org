<?php 
    require_once('../db.php');
    
    try {
        $goalId = intval($_POST['goal_id']); 
        $typeId = intval($_POST['type_id']);
        $goalName = trim($_POST['goal_name']);
        $targetName = trim($_POST['target_name']);
        $targetAmount = floatval($_POST['target_amount']);
        $savedAmount = floatval($_POST['saved_amount']);
        $statusId = intval($_POST['status_id']);
        
        $lastModified = date('Y-m-d H:i:s');
    
        if (empty($goalName) || empty($targetName) || empty($targetAmount) || empty($savedAmount)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../?page=finance-goals&action=edit&id=' . $goalId);
            exit;
        }

        //check if the given fields are the same as the ones in the database
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
        $dbTargetName = trim($goal['target_date']);
        $dbStatusId = intval($goal['status_id']);

        if (
            $dbGoalName === $goalName &&
            $dbTypeId === $typeId &&
            $dbTargetAmount === $targetAmount &&
            $dbSavedAmount === $savedAmount &&
            $dbTargetName === $targetName &&
            $dbStatusId === $statusId
        ) {
            // Няма промени
            $_SESSION['error'] = 'Няма направени промени.';
            header('Location: ../?page=finance-goals&action=edit&id=' . $goalId);
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
            ':target_date' => $targetName,
            ':status_id' => $statusId,
            ':last_modified' => $lastModified,
            ':goal_id' => $goalId,
        ]);
    
        $_SESSION['success'] = 'Целта беше успешно актуализирана.';
        header('Location: ../?page=finance-goals&action=edit&id=' . $goalId);
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Грешка при актуализация: ' . $e->getMessage();
        header('Location: ../?page=finance-goals&action=edit&id=' . $goalId);
        exit;
    }
    
?>