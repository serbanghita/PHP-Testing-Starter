<?php
namespace UnitTests\OutputTest;

class View
{
    protected $assignedVars = array();

    public function assign($name, $value)
    {
        $this->assignedVars[$name] = $value;
    }

    public function render($template)
    {
        $view = $this->assignedVars;
        include_once dirname(__FILE__) . '/' . $template . '.inc.php';
    }
}