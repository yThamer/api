<?php
// هذا الملف هو الوسيط الذي سيعمل على سيرفر آخر (Vercel)

// السماح بالطلبات من أي مصدر (لأن موقعك على InfinityFree سيتصل به)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// التأكد من أن الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

// الوجهة هي سيرفر الدسكورد
$discord_token_url = 'https://discord.com/api/oauth2/token';

// أخذ البيانات التي أرسلها موقعك (من InfinityFree)
$data = $_POST;

// إعادة إرسال البيانات إلى الدسكورد باستخدام cURL
$ch = curl_init($discord_token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// إرجاع الرد الذي جاء من الدسكورد إلى موقعك الأصلي
http_response_code($http_code);
echo $result;