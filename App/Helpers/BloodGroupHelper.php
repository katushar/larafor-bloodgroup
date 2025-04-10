<?php
// app/Helpers/BloodGroupHelper.php
namespace Larafor\Bloodgroup\App\Helpers;

class BloodGroupHelper
{
    public static function normalize(string $input): ?string
    {
        $name = strtoupper(trim($input));
        $name = str_replace(['(', ')', ' ', 'VE', 'POSITIVE', 'NEGATIVE'], '', $name);
        $name = str_replace(['POS', '+VE', '+VE'], '+', $name);
        $name = str_replace(['NEG', '-VE', '-VE'], '-', $name);

        $patterns = [
            '/^A\+?$/' => 'A+',
            '/^A-$/' => 'A-',
            '/^B\+?$/' => 'B+',
            '/^B-$/' => 'B-',
            '/^AB\+?$/' => 'AB+',
            '/^AB-$/' => 'AB-',
            '/^O\+?$/' => 'O+',
            '/^O-$/' => 'O-',
        ];

        foreach ($patterns as $pattern => $replacement) {
            if (preg_match($pattern, $name)) {
                return $replacement;
            }
        }

        return null;
    }
}
