<?php
namespace Examples\ProtectedProperties;

class MyClass
{
    private function mapProduct($id)
    {
        return 'Product' . $id;
    }

    protected function mapCategory($id)
    {
        return 'Category' . $id;
    }
}