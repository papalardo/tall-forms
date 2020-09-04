<?php

namespace App;

class Helper
{
    public static function normalizePath($path, $encoding="UTF-8")
    {
  
        // Attempt to avoid path encoding problems.
        $path = iconv($encoding, "$encoding//IGNORE//TRANSLIT", $path);
      
        // Process the components
        $parts = explode('/', $path);
        $safe = array();
        foreach ($parts as $idx => $part) {
            if (empty($part) || ('.' == $part)) {
                continue;
            } elseif ('..' == $part) {
                array_pop($safe);
                continue;
            } else {
                $safe[] = $part;
            }
        }
        
        // Return the "clean" path
        $path = implode(DIRECTORY_SEPARATOR, $safe);
        return $path;
    }

    public static function formatBytes($bytes, $to, $decimal_places = 2)
    {
        $formulas = array(
            'K' => number_format($bytes / 1024, $decimal_places),
            'M' => number_format($bytes / 1048576, $decimal_places),
            'G' => number_format($bytes / 1073741824, $decimal_places)
        );
        return isset($formulas[$to]) ? $formulas[$to] : 0;
    }
}
