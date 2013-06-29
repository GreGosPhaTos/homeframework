<?php
namespace HomeFramework\manager;

class EntityManager {

    /**
     * @var
     */
    protected $api;

    /**
     * @var
     */
    protected $dao;

    /**
     * @var
     */
    private $namespace;

    /**
     * @var array
     */
    protected $managers = array();

    /**
     * @param $api
     * @param $dao
     * @param $namespace
     */
    public function __construct($api, $dao, $namespace) {
        $this->api = $api;
        $this->dao = $dao;
        $this->namespace = $namespace;
    }

    /**
     * @param $module
     * @return mixed
     */
    public function getManagerOf($module) {
        if (!isset($this->managers[$module])) {
            $manager = $this->namespace.$module.'Manager_'.$this->api;
            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }

}