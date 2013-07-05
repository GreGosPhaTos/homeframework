<?php
namespace HomeFramework\reader;

use HomeFramework\common\IReader;

class PathReader implements IReader {
    /**
     * @param array $remplacements
     * @param $subject
     * @return mixed
     */
    public function read(array $remplacements, $subject) {
        foreach ($remplacements as $pattern => $remplacement) {
            $subject = preg_replace("/(\{".$pattern."\})/", $remplacement, $subject);
        }

        return $subject;
    }
}