<?php

namespace Database\Seeders\Concerns;

/**
 * Genere des images de substitution (degrade + silhouette) uniquement avec
 * GD (deja requis par les conversions d'images du projet, cf.
 * config/media-library.php : image_driver = gd), sans police externe ni
 * acces reseau. Utilise par les seeders de demonstration pour ne plus
 * dependre d'un service tiers (picsum.photos) au moment du seed.
 */
trait GeneratesPlaceholderImages
{
    /**
     * @return string Chemin du fichier JPEG temporaire genere (a consommer
     *                 avec addMedia(), qui le deplace et le supprime).
     */
    private function generatePlaceholderImage(string $seedLabel, int $width = 1200, int $height = 900): string
    {
        $palette = [
            ['from' => [214, 211, 199], 'to' => [237, 235, 228]], // sable
            ['from' => [198, 208, 211], 'to' => [227, 232, 234]], // gris bleuté
            ['from' => [212, 200, 190], 'to' => [234, 226, 218]], // terre cuite claire
            ['from' => [190, 200, 191], 'to' => [221, 227, 221]], // vert sauge
        ];

        $colors = $palette[crc32($seedLabel) % count($palette)];
        [$r1, $g1, $b1] = $colors['from'];
        [$r2, $g2, $b2] = $colors['to'];

        $image = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $color = imagecolorallocate(
                $image,
                (int) ($r1 + ($r2 - $r1) * $ratio),
                (int) ($g1 + ($g2 - $g1) * $ratio),
                (int) ($b1 + ($b2 - $b1) * $ratio)
            );
            imageline($image, 0, $y, $width, $y, $color);
        }

        // Silhouette de toit, ton legerement plus soutenu que le fond, pour
        // eviter un aplat de couleur trop plat sur les cartes/carrousels.
        $roofColor = imagecolorallocate($image, (int) ($r1 * 0.85), (int) ($g1 * 0.85), (int) ($b1 * 0.85));
        imagefilledpolygon($image, [
            (int) ($width * 0.12), (int) ($height * 0.66),
            (int) ($width * 0.5), (int) ($height * 0.36),
            (int) ($width * 0.88), (int) ($height * 0.66),
        ], $roofColor);

        $path = tempnam(sys_get_temp_dir(), 'demo_image_').'.jpg';
        imagejpeg($image, $path, 82);
        imagedestroy($image);

        return $path;
    }
}
