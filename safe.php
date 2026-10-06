<?php
// Этот фрагмент предназначен для среды DVWA, где соединение с БД уже создано.
if (isset($_GET['Submit'])) {
    $id = $_GET['id'] ?? '';

    if (!ctype_digit($id)) {
        $html .= '<pre>Некорректный ID.</pre>';
    } else {
        $db = $GLOBALS['___mysqli_ston'];

        $stmt = mysqli_prepare(
            $db,
            'SELECT first_name, last_name FROM users WHERE user_id = ?'
        );

        if ($stmt === false) {
            $html .= '<pre>Ошибка обработки запроса.</pre>';
        } else {
            $userId = (int) $id;
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $html .= mysqli_stmt_num_rows($stmt) > 0
                ? '<pre>User ID exists in the database.</pre>'
                : '<pre>User ID is MISSING from the database.</pre>';

            mysqli_stmt_close($stmt);
        }
    }
}