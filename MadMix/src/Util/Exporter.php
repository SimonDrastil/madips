<?php
declare(strict_types=1);

namespace MadMix\Util;

use RuntimeException;

final class Exporter
{
    public static function png(string $title, string $body): string
    {
        if (!function_exists('imagecreatetruecolor')) {
            throw new RuntimeException('GD extension not available');
        }

        $width = 900;
        $lineHeight = 28;
        $padding = 40;
        $fontPath = __DIR__ . '/../../public/assets/OpenSans-Regular.ttf';
        $useTtf = is_file($fontPath) && function_exists('imagettftext');

        $lines = explode("\n", wordwrap($body, 70));
        $height = $padding * 2 + $lineHeight * (count($lines) + 2);

        $image = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($image, 250, 248, 244);
        $textColor = imagecolorallocate($image, 40, 40, 40);
        imagefill($image, 0, 0, $background);

        if ($useTtf) {
            imagettftext($image, 24, 0, $padding, $padding + 10, $textColor, $fontPath, $title);
            $y = $padding + 50;
            foreach ($lines as $line) {
                imagettftext($image, 16, 0, $padding, $y, $textColor, $fontPath, $line);
                $y += $lineHeight;
            }
        } else {
            imagestring($image, 5, $padding, $padding, $title, $textColor);
            $y = $padding + 40;
            foreach ($lines as $line) {
                imagestring($image, 4, $padding, $y, $line, $textColor);
                $y += 20;
            }
        }

        ob_start();
        imagepng($image);
        imagedestroy($image);
        return (string)ob_get_clean();
    }

    public static function pdf(string $title, string $body): string
    {
        $body = str_replace(["\r\n", "\r"], "\n", $body);
        $lines = explode("\n", $body);
        $contents = "BT /F1 20 Tf 72 780 Td (" . self::escapePdf($title) . ") Tj ET\n";
        $contents .= "BT /F1 12 Tf 72 740 Td ";
        foreach ($lines as $line) {
            $contents .= '(' . self::escapePdf($line) . ') Tj T* ';
        }
        $contents .= 'ET';
        $length = strlen($contents);

        $pdf = "%PDF-1.4\n";
        $pdf .= "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n";
        $pdf .= "2 0 obj<< /Type /Pages /Kids[3 0 R] /Count 1 >>endobj\n";
        $pdf .= "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox[0 0 612 792] /Resources<< /Font<< /F1 4 0 R >> >> /Contents 5 0 R >>endobj\n";
        $pdf .= "4 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n";
        $offset = strlen($pdf);
        $pdf .= "5 0 obj<< /Length $length >>stream\n$contents\nendstream endobj\n";
        $xref = $offset + strlen("5 0 obj<< /Length $length >>stream\n$contents\nendstream endobj\n");
        $pdf .= "xref\n0 6\n0000000000 65535 f \n";
        $offsets = [0];
        $cursor = 0;
        foreach (['1 0 obj', '2 0 obj', '3 0 obj', '4 0 obj', '5 0 obj'] as $object) {
            $cursor = strpos($pdf, $object, $cursor);
            $offsets[] = $cursor;
        }
        for ($i = 1; $i <= 5; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer<< /Size 6 /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
        return $pdf;
    }

    private static function escapePdf(string $line): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
    }
}
