<?php
    require_once('../../db.php');

    try {
        $liabilityId = intval($_POST['liability_id']);
        $liabilityTypeId = intval($_POST['liability_type_id']);
        $liabilityName = trim($_POST['liability_name']);
        $targetAmount = floatval($_POST['target_amount']);
        $paidAmount = floatval($_POST['paid_amount']);
        $targetDate = date('Y-m-d', strtotime($_POST['target_date']));
        $statusId = intval($_POST['status_id']);

        $lastModified = date('Y-m-d H:i:s');
       
        if (empty($liabilityName) || empty($targetAmount)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        if (empty($_POST['target_date']) || !strtotime($_POST['target_date'])) {
            $_SESSION['error'] = 'Въведете валидна целева дата.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        if (!is_numeric($targetAmount) || $targetAmount < 0) {
            $_SESSION['error'] = 'Въведете валидна целева сума.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        if ($paidAmount > $targetAmount) {
            $_SESSION['error'] = 'Платената сума не може да бъде по-голяма от целевата сума.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        if (!is_numeric($paidAmount) || $paidAmount < 0) {
            $_SESSION['error'] = 'Въведете валидна платена сума.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        $stmt = $pdo->prepare('
            SELECT 
                liability_name,
                liability_type_id,
                target_amount,
                paid_amount,
                target_date,
                status_id
            FROM 
                financial_liabilities
            WHERE 
                liability_id = :liability_id
        ');
        $stmt->execute([':liability_id' => $liabilityId]);
        $liability = $stmt->fetch();

        $dbLiabilityName = trim($liability['liability_name']);
        $dbTypeId = intval($liability['liability_type_id']);
        $dbTargetAmount = floatval($liability['target_amount']);
        $dbPaidAmount = floatval($liability['paid_amount']);
        $dbTargetDate = date('Y-m-d', strtotime($liability['target_date']));
        $dbStatusId = intval($liability['status_id']);

        if ($liabilityName === $dbLiabilityName && $liabilityTypeId === $dbTypeId && $targetAmount === $dbTargetAmount && $paidAmount === $dbPaidAmount && $targetDate === $dbTargetDate && $statusId === $dbStatusId) {
            $_SESSION['error'] = 'Няма направени промени.';
            header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
            exit;
        }

        $stmt = $pdo->prepare('
            UPDATE 
                financial_liabilities
            SET 
                liability_name = :liability_name,
                liability_type_id = :liability_type_id,
                target_amount = :target_amount,
                paid_amount = :paid_amount,
                target_date = :target_date,
                status_id = :status_id,
                last_modified = :last_modified
            WHERE 
                liability_id = :liability_id
        ');

        $stmt->execute([
            ':liability_name' => $liabilityName,
            ':liability_type_id' => $liabilityTypeId,
            ':target_amount' => $targetAmount,
            ':paid_amount' => $paidAmount,
            ':target_date' => $targetDate,
            ':status_id' => $statusId,
            ':last_modified' => $lastModified,
            ':liability_id' => $liabilityId
        ]);

        $_SESSION['success'] = 'Успешно редактирано задължение.';
        header('Location: ../../?page=my-credits');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Възникна грешка при редакция на задължение: ' . $e->getMessage();
        header('Location: ../../?page=my-credits&action=edit&id=' . $liabilityId);
        exit;
    }

?>