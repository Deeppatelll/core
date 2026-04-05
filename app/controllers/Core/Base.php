<?php
require_once 'app/models/Core/Request.php';

class Controller_Core_Base
{
    protected $request = null;

    public function getRequest()
    {
        if ($this->request) {
            return $this->request;
        }
        $request = new Model_Request();
        $this->setRequest($request);
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function dispatch()
    {
        $action = $this->getRequest()->get('a', 'list');
        $action .= 'Action';

        if (!method_exists($this, $action)) {
            die("Action not found: " . $action);
        }

        $this->$action();
    }

    public function redirect($a = null, $c = null)
    {
        if (!$a) {
            $a = $this->getRequest()->get('a');
        }

        if (!$c) {
            $c = $this->getRequest()->get('c');
        }

        header("Location: index.php?c=$c&a=$a");
        exit;
    }

    public function renderTemplate($template, $data = [])
    {
        extract($data);
        
        $templatePath = 'app/templates/' . $template;

        if (!file_exists($templatePath)) {
            die("Template not found: " . $templatePath);
        }

        include $templatePath;
    }
}