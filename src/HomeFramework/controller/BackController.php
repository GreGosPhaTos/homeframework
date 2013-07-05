<?php
namespace HomeFramework\controller;


use HomeFramework\container\ContainerAware,
    HomeFramework\common\IAccess;

/**
 * Class BackController
 * @package HomeFramework\controller
 *
 * @todo implements SplSubject ???
 */
abstract class BackController extends ContainerAware {
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
     * @var array
     */
    protected $vars = array();

    /**
     * @var
     */
    private $layout;


    /**
     * @param \HomeFramework\common\IAccess $container
     * @param $module
     * @param $action
     * @param $vars
     */
    public function __construct(IAccess $container, $module, $action, $vars) {
        $this->setContainer($container);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVars($vars);
        // @TODO Sortir du Constructeur
        $config = $this->container->get('DefaultConfiguration');
        $configReader = $this->container->get($config->get('reader'));

        $templateConfig = $config->get('template');
        $replacement = array(
            'appName' => $this->container->get('ApplicationName'),
            'module' => $this->module,
            'view' => $this->action,
        );
        $templateConfig['view'] = $configReader->read($replacement, $templateConfig['view']);
        $this->setView($templateConfig['view']);

        $replacement = array(
            'appName' => $this->container->get('ApplicationName'),
        );
        $templateConfig['layout'] = $configReader->read($replacement, $templateConfig['layout']);
        $this->setLayout($templateConfig['layout']);

        $config->set('template', $templateConfig);
    }

    /**
     * @throws \RuntimeException
     */
    public function execute() {
        $method = 'on'.ucfirst($this->action);

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
     * @param array $vars
     */
    public function setVars(array $vars) {
        $this->vars = $vars;
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

        require $this->view;
        $content = ob_get_contents();
        ob_clean();

        require $this->layout;

        return ob_end_flush();
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