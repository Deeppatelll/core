<?php
require_once 'app/controllers/Core/Base.php';
require_once 'app/models/Product.php';

class Controller_Product extends Controller_Core_Base
{
    public function listAction()
    {
        $model = new Model_Product();
        $data = $model->fetchAll();

        $this->renderTemplate('product/list.phtml', [
            'data' => $data
        ]);
    }

    public function editAction()
    {
        $model = new Model_Product();
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model->load($id);
        }

        $this->renderTemplate('product/edit.phtml', [
            'data' => $model
        ]);
    }

    public function saveAction()
    {
        $model = new Model_Product();

        foreach ($_POST['product'] as $key => $value) {
            $model->$key = $value;
        }

        $pk = $model->getPrimaryKey();
        $id = $model->$pk;

        if ($id) {
            $existing = new Model_Product();
            $existing->load($id);

            if (!$existing->$pk) {
                throw new Exception('Product not found for update.');
            }
        } else {
            // New record, continue.
        }

        $model->save();

        $this->redirect('list', 'product');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model = new Model_Product();
            $model->load($id);
            $pk = $model->getPrimaryKey();

            if (!$model->$pk) {
                throw new Exception('Product not found for delete.');
            } else {
                $model->delete();
            }
        } else {
            throw new Exception('Missing product id.');
        }

        $this->redirect('list', 'product');
    }
}