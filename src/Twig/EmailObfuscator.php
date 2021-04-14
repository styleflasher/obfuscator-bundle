<?php

namespace Styleflasher\ObfuscatorBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class EmailObfuscator implements RuntimeExtensionInterface
{
    public function obfuscateEmail(string $content): string
    {
        // Casting $string to a string allows passing of objects implementing the __toString() magic method.
        $string = (string)$content;

        // Safeguard string.
        $safeguard = '$%$!!$%$';

        // Safeguard several stuff before parsing.
        $prevent = [
            '|<input [^>]*@[^>]*>|is', // <input>
            '|(<textarea(?:[^>]*)>)(.*?)(</textarea>)|is', // <textarea>
            '|(<head(?:[^>]*)>)(.*?)(</head>)|is', // <head>
            '|(<script(?:[^>]*)>)(.*?)(</script>)|is', // <script>
        ];
        foreach ($prevent as $pattern) {
            $string = preg_replace_callback($pattern, function ($matches) use ($safeguard) {
                return str_replace('@', $safeguard, $matches[0]);
            }, $string);
        }

        // Define patterns for extracting emails.
        $patterns = [
            '|\<a[^>]+href\=\"mailto\:([^">?]+)(\?[^?">]+)?\"[^>]*\>(.*?)\<\/a\>|ism', // mailto anchors
            '|[_a-z0-9-]+(?:\.[_a-z0-9-]+)*@[a-z0-9-]+(?:\.[a-z0-9-]+)*(?:\.[a-z]{2,3})|i', // plain emails
        ];

        foreach ($patterns as $pattern) {
            $string = preg_replace_callback($pattern, function ($parts) use ($safeguard) {
                // Clean up element parts.
                $parts = array_map('trim', $parts);

                // ROT13 implementation for JS-enabled browsers
//                $js = '<script type="text/javascript">Rot13.write(' . "'" . str_rot13($parts[0]) . "'" . ');</script>';
//
//                // Reversed direction implementation for non-JS browsers
//                if (0 === stripos($parts[0], '<a')) {
//                    // Mailto tag; if link content equals the email, just display the email, otherwise display a formatted string.
//                    $nojs = ($parts[1] == $parts[3]) ? $parts[1] : (' > ' . $parts[1] . ' < ' . $parts[3]);
//                } else {
//                    // Plain email; display the plain email.
//                    $nojs = $parts[0];
//                }
//                $nojs = '<noscript><span style="unicode-bidi:bidi-override;direction:rtl;">' . strrev($nojs) . '</span></noscript>';

                // for Vue application
                $js = "<template class=\"email-obfuscation\">" . str_rot13($parts[0]) . "</template>";

                // Safeguard the obfuscation so it won't get picked up by the next iteration.
                return str_replace('@', $safeguard, $js);
            }, $string);
        }

        // Revert all safeguards.
        return str_replace($safeguard, '@', $string);
    }
}
