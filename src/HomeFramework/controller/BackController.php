<?php
namespace HomeFramework\controller;


use HomeFramework\container\ContainerAware,
    HomeFramework\container\IContainer;

abstract class BackController extends ContainerAware implements \SplSubject {
    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var string
     */
    protected $module = '';

    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var
     */
    private $layout;

    /**
     * @var array
     */
    private $vars = array();

    /**
     * @param \HomeFramework\container\IContainer $container
     * @param $module
     * @param $action
     */
    public function __construct(IContainer $container, $module, $action) {
        $this->setContainers($container);
        $this->setModule($module);
        $this->setAction($action);
        // @TODO Sortir du Constructeur
        $config = $this->container->get('DefaultConfiguration');
        $configReader = $this->container($config->get('reader'));

        $templateConfig = $config->get('template');
        $replacement = array(
            'appName' => $this->container->get('Application')->getName(),
            'module' => $this->module,
            'view' => $this->view,
        );
        $templateConfig['view'] = $configReader->read($replacement, $templateConfig['file']);
        $this->setView($templateConfig['view']);

        $replacement = array(
            'appName' => $this->container->get('Application')->getName(),
        );
        $templateConfig['layout'] = $configReader->read($replacement, $templateConfig['layout']);
        $this->setView($templateConfig['view']);

        $config->set('template', $templateConfig);
    }

    /**
     * @throws \RuntimeException
     */
    public function execute() {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable(array($this, $method))) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }

        $this->$method();
    }

    /**
     * @param $module
     * @throws \InvalidArgumentException
     */
    public function setModule($module) {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }

        $this->module = $module;
    }

    /**
     * @param $action
     * @throws \InvalidArgumentException
     */
    public function setAction($action) {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    /**
     * @param $view
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function setView($view) {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        if (!file_exists($view)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $this->view = $view;
    }

    /**
     * @param $var
     * @param $value
     * @throws \InvalidArgumentException
     */
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
    public function renderView() {
        //$user = $this->app->user();
        extract($this->vars);
        ob_start();
        require $this->contentFile;
        $content = ob_get_contents();

        require $this->layoutFile;
        return ob_get_clean();
    }

    /**
     * @param $layoutFile
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @internal param $layoutFile
     *
     * @TODO FileSystem ?
     */
    public function setLayout($layoutFile) {
        if (!is_string($layoutFile) || empty($layoutFile)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $this->layout = $layoutFile;
    }
}