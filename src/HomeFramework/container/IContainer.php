<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 23/07/13
 * Time: 21:19
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;

interface IContainer {

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get($serviceName);

    /**
     * Add a service to the container
     *
     * @param Service $service
     * @return mixed
     */
    public function setService(Service $service);

    /**
     * Returns the Service.
     *
     * @return Service
     */
    public function getService();

    /**
     *
     * @return mixed
     */
    public function fetchService();

    /**
     * Attach a new subscriber
     *
     * @param IContainerSubscriber $subscriber
     * @return mixed
     */
    public function subscribe(IContainerSubscriber $subscriber);

    /**
     * UnSubscribe a subscriber
     *
     * @param IContainerSubscriber $subscriber
     * @return mixed
     */
    public function unSubscribe(IContainerSubscriber $subscriber);

}