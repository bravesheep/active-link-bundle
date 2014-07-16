<?php

namespace Bravesheep\ActiveLinkBundle\Twig;

use Bravesheep\ActiveLinkBundle\ActiveChecker;

class BravesheepActiveLinkExtension extends \Twig_Extension
{
    /**
     * Default output for route checking functions
     */
    const DEFAULT_ACTIVE_TEXT = 'active';

    /**
     * @var ActiveChecker
     */
    private $checker;

    /**
     * @param ActiveChecker $checker
     */
    public function __construct(ActiveChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('active_controller', [$this, 'activeController']),
            new \Twig_SimpleFunction('active_action', [$this, 'activeAction']),
            new \Twig_SimpleFunction('active_bundle', [$this, 'activeBundle']),
            new \Twig_SimpleFunction('active_route', [$this, 'activeRoute']),
            new \Twig_SimpleFunction('active', [$this, 'active']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('active_controller', [$this, 'isActiveController']),
            new \Twig_SimpleTest('active_action', [$this, 'isActiveAction']),
            new \Twig_SimpleTest('active_bundle', [$this, 'isActiveBundle']),
            new \Twig_SimpleTest('active_route', [$this, 'isActiveRoute']),
            new \Twig_SimpleTest('active', [$this, 'isActive']),
        ];
    }

    /**
     * @see ActiveChecker::isActiveController
     * @param string $controller
     * @param array $params
     * @return bool
     *
     */
    public function isActiveController($controller, array $params = [])
    {
        return $this->checker->isActiveController($controller, $params);
    }

    /**
     * @see ActiveChecker::isActiveAction
     * @param string $action
     * @param array $params
     * @return bool
     */
    public function isActiveAction($action, array $params = [])
    {
        return $this->checker->isActiveAction($action, $params);
    }

    /**
     * @see ActiveChecker::isActiveBundle
     * @param string $bundle
     * @param array $params
     * @return bool
     */
    public function isActiveBundle($bundle, array $params = [])
    {
        return $this->checker->isActiveBundle($bundle, $params);
    }

    /**
     * @see ActiveChecker::isActiveRoute
     * @param string $route
     * @param array $params
     * @return bool
     */
    public function isActiveRoute($route, array $params = [])
    {
        return $this->checker->isActiveRoute($route, $params);
    }

    /**
     * @see ActiveChecker::isActive
     * @param string $what
     * @param array $params
     * @return bool
     */
    public function isActive($what, array $params = [])
    {
        return $this->checker->isActive($what, $params);
    }

    /**
     * Returns the output if the given controller is active. Returns false otherwise.
     * @param string $controller Class name of a controller
     * @param array  $params     Array of params which should be active.
     * @param mixed  $output     Output that should be returned
     * @return mixed
     */
    public function activeController($controller, array $params = [], $output = self::DEFAULT_ACTIVE_TEXT)
    {
        if ($this->isActiveController($controller, $params)) {
            return $output;
        } else {
            return false;
        }
    }

    /**
     * Returns the output if the given action method is active. Returns false otherwise.
     * @param string $action Class name and action method of the action that should be checked
     * @param array  $params Array of params which should be active.
     * @param mixed  $output Output that should be returned
     * @return mixed
     */
    public function activeAction($action, array $params = [], $output = self::DEFAULT_ACTIVE_TEXT)
    {
        if ($this->isActiveAction($action, $params)) {
            return $output;
        } else {
            return false;
        }
    }

    /**
     * Returns the output if the given bundle is active. Returns false otherwise.
     * @param string $bundle Name of the bundle that should be checked
     * @param array  $params Array of params which should be active.
     * @param string $output Output that should be returned
     * @return mixed
     */
    public function activeBundle($bundle, array $params = [], $output = self::DEFAULT_ACTIVE_TEXT)
    {
        if ($this->isActiveBundle($bundle, $params)) {
            return $output;
        } else {
            return false;
        }
    }

    /**
     * Returns the output if the given route is active. Returns false otherwise.
     * @param string $route  Named route
     * @param array  $params Array of params which should be active.
     * @param mixed  $output Output that should be returned
     * @return mixed
     */
    public function activeRoute($route, array $params = [], $output = self::DEFAULT_ACTIVE_TEXT)
    {
        if ($this->isActiveRoute($route, $params)) {
            return $output;
        } else {
            return false;
        }
    }

    /**
     * Returns the output if the given route is active. Returns false otherwise.
     * @param string $what   Bundle, Controller class, or action method to be checked.
     * @param array  $params Array of params which should be active.
     * @param mixed  $output Output that should be returned
     * @return mixed
     */
    public function active($what, array $params = [], $output = self::DEFAULT_ACTIVE_TEXT)
    {
        if ($this->isActive($what, $params)) {
            return $output;
        } else {
            return false;
        }
    }

    public function getName()
    {
        return 'bravesheep_active_link_extension';
    }
}
