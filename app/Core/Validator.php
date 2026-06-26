<?php
declare(strict_types=1);

namespace App\Core;

final class Validator
{
    public static function required(array $data, array $fields): array
    {
        $errors = [];
        foreach ($fields as $field) {
            if (trim((string) ($data[$field] ?? '')) === '') {
                $errors[$field] = 'هذا الحقل مطلوب.';
            }
        }
        return $errors;
    }

    public static function contact(array $data): array
    {
        $errors = self::required($data, ['name', 'phone', 'service']);
        if (!empty($data['phone']) && !preg_match('/^[0-9+\s-]{7,20}$/', (string) $data['phone'])) {
            $errors['phone'] = 'رقم الهاتف غير صحيح.';
        }
        return $errors;
    }
}
