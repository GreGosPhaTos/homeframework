<?php
namespace HomeFramework\manager;

abstract class Manager
{
    /**
     * @var Object Connexion
     */
    protected $dao;

    /**
     * @param $dao
     */
    public function __construct($dao) {
        $this->dao = $dao;
    }
}
