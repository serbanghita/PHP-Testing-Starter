<?php
namespace UnitTests\OutputTest;

class Controller
{
    protected $model;
    protected $view;

    public function __construct(Model $model, View $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function index()
    {
        $this->view->assign('name', $this->model->getUsername());
        $this->view->render('block');
    }

}