<?php
namespace HomeFramework\reader;

use HomeFramework\common\IReader;

class PathReader implements IReader {
    /**
     * @param array $remplacement
     * @param $subject
     * @return mixed
     */
    public function read(array $remplacement, $subject) {
        return preg_replace("/(\{\w\})/\e", "\$remplacement[$1]", $subject);
    }
}