<?php
require_once 'app/controllers/Core/Base.php';
require_once 'app/models/Productmedia.php';

class Controller_Productmedia extends Controller_Core_Base
{
    public function listAction()
    {
        $model = new Model_Productmedia();
        $data = $model->fetchAll();

        $this->renderTemplate('productmedia/list.phtml', [
            'data' => $data
        ]);
    }

    public function editAction()
    {
        $model = new Model_Productmedia();
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model->load($id);
        }

        $this->renderTemplate('productmedia/edit.phtml', [
            'data' => $model
        ]);
    }

    public function saveAction()
    {
        $model = new Model_Productmedia();

        foreach ($_POST['productmedia'] as $key => $value) {
            $model->$key = $value;
        }

        $pk = $model->getPrimaryKey();
        $id = $model->$pk;

        if ($id) {
            $existing = new Model_Productmedia();
            $existing->load($id);

            if (!$existing->$pk) {
                throw new Exception('Product media not found for update.');
            }
        } else {
            // New record, continue.
        }

        $model->save();

        $this->redirect('list', 'productmedia');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model = new Model_Productmedia();
            $model->load($id);
            $pk = $model->getPrimaryKey();

            if (!$model->$pk) {
                throw new Exception('Product media not found for delete.');
            } else {
                $model->delete();
            }
        } else {
            throw new Exception('Missing product media id.');
        }

        $this->redirect('list', 'productmedia');
    }
}
