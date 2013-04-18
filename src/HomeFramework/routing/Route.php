<?php
namespace HomeFramework\routing;

class Route
{

    /**
     * The action in Controller
     *
     * @var $action
     */
    protected $action;

    protected $module;

    protected $url;

    protected $varsNames;

    protected $vars = array();

    /**
     * Returns if vars is empty
     *
     * @return bool
     */
    public function hasVars() {
        return !empty($this->varsNames);
    }

    /**
     *
     *
     * @param String $url
     * @return bool
     */
    public function match($url) {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            return $matches;
        } else {
            return false;
        }
    }

    /**
     * @param $action
     */
    public function setAction($action) {
        if(is_string($action)) {
            $this->action = $action;
        }
    }

    /**
     * @param $module
     */
    public function setModule($module) {
        if(is_string($module)) {
            $this->module = $module;
        }
    }

    /**
     * @param $url
     */
    public function setUrl($url) {
        if(is_string($url)) {
            $this->url = $url;
        }
    }

    /**
     * @param array $varsNames
     */
    public function setVarsNames(array $varsNames) {
        $this->varsNames = $varsNames;
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars) {
        $this->vars = $vars;
    }

    /**
     * @return mixed
     */
    public function action() {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function module() {
        return $this->module;
    }

    /**
     * @return array
     */
    public function vars() {
        return $this->vars;
    }

    /**
     * @return mixed
     */
    public function varsNames() {
        return $this->varsNames;
    }
}