<?php

namespace Bravesheep\ActiveLinkBundle;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class ActiveChecker
{
    private $requestStack;

    private $kernel;

    public function __construct(Kernel $kernel, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->kernel = $kernel;
    }

    /**
     * Check if the given route is active.
     * @param string $what
     * @param array $params
     * @return bool
     */
    public function isActive($what, array $params = [])
    {
        $items = explode(':', $what);
        switch (count($items)) {
            case 1:
                $result = $this->isActiveBundle($what, $params);
                if (false === $result) {
                    $result = $this->isActiveController($what, $params);
                }
                break;
            case 2:
                $result = $this->isActiveController($what, $params);
                if (false === $result) {
                    $result = $this->isActiveAction($what, $params);
                }
                break;
            case 3:
                $result = $this->isActiveAction($what, $params);
                break;
            default:
                $result = false;
        }

        return $result;
    }

    public function isActiveRoute($route, array $params = [])
    {
        $activeRoute = $this->requestStack->getMasterRequest()->get('_route');
        $route = preg_quote($route, '@');
        $route = str_replace(['\*', '\+'], ['(.*?)', '(.+?)'], $route);
        if (preg_match('@^' . $route . '$@', $activeRoute) === 1) {
            return $this->hasParams($params);
        } else {
            return false;
        }
    }

    /**
     * Check if the given controller is currently active.
     * @param string $controller
     * @param array $params
     * @return bool
     */
    public function isActiveController($controller, array $params = [])
    {
        $active_controller = $this->requestStack->getMasterRequest()->get('_controller');

        if (substr_count($controller, ':') === 1) {
            list($bundle, $controller_name) = explode(':', $controller);

            try {
                $bundle = $this->kernel->getBundle($bundle);
            } catch (\InvalidArgumentException $e) {
                return false;
            }

            $ns = $bundle->getNamespace() . '\\Controller\\' . $controller_name . 'Controller::';

            return strpos($active_controller, $ns) === 0 && $this->hasParams($params);
        } else {
            return strpos($active_controller, $controller . ':') === 0 && $this->hasParams($params);
        }
    }

    /**
     * Check if the given action is active.
     * @param string $action
     * @param array $params
     * @return bool
     */
    public function isActiveAction($action, array $params = [])
    {
        $active_controller = $this->requestStack->getMasterRequest()->get('_controller');

        if (substr_count($action, ':') === 2) {
            list($bundle, $controller_name, $action_name) = explode(':', $action);
            $bundle = $this->kernel->getBundle($bundle);
            $ns = $bundle->getNamespace() . '\\Controller\\' . $controller_name . 'Controller::' . $action_name;

            return $active_controller === $ns && $this->hasParams($params);
        } else {
            return $active_controller === $action && $this->hasParams($params);
        }
    }

    /**
     * Check if the given bundle is active.
     * @param string $bundle Name of the bundle that should be checked
     * @param array $params Parameters to be checked
     * @return bool
     */
    public function isActiveBundle($bundle, array $params = [])
    {
        try {
            /** @var BundleInterface $bundle */
            $bundle = $this->kernel->getBundle($bundle);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        $active_controller = $this->requestStack->getMasterRequest()->get('_controller');
        $ns = $bundle->getNamespace() . '\\Controller\\';
        if (strpos($active_controller, $ns) === 0) {
            return $this->hasParams($params);
        } elseif (strpos($active_controller, $bundle->getContainerExtension()->getAlias() . '.') === 0) {
            return $this->hasParams($params);
        } else {
            return false;
        }
    }

    /**
     * Check if the list of parameters is in the current request.
     * @param array $params
     * @return bool
     */
    public function hasParams(array $params = [])
    {
        $request = $this->requestStack->getMasterRequest();
        foreach ($params as $param => $value) {
            $data = $request->attributes->get($param, $request->query->get($param));
            if ($data !== $value) {
                return false;
            }
        }

        return true;
    }
}
