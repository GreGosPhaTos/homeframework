<?php
namespace HomeFramework\page;

class Page {

    /**
     * @var
     *
     */
    private $contentFile;

    /**
     * @var
     */
    private $layoutFile;

    /**
     * @var array
     */
    private $vars = array();

    public function addVar($var, $value) {
        if (!is_string($var) || is_numeric($var) || empty($var)) {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
        }

        $this->vars[$var] = $value;
    }

    /**
     * @return string
     * @throws \RuntimeException
     *
     * @TODO gerer la session
     */
    public function getGeneratedPage() {
        //$user = $this->app->user();
        extract($this->vars);
        ob_start();
        require $this->contentFile;
        $content = ob_get_clean();

        ob_start();
        require $this->layoutFile;
        return ob_get_clean();
    }

    /**
     * @param $contentFile
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function setContentFile($contentFile) {
        if (!is_string($contentFile) || empty($contentFile)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        if (!file_exists($this->contentFile)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $this->contentFile = $contentFile;
    }

    /**
     * @param $layoutFile
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @internal param $layoutFile
     *
     * @TODO FileSystem ?
     */
    public function setLayoutFile($layoutFile) {
        if (!is_string($layoutFile) || empty($layoutFile)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $this->layoutFile = $layoutFile;
    }
}