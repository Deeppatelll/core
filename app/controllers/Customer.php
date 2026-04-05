<?php
require_once 'app/controllers/Core/Base.php';
require_once 'app/models/Customer.php';

class Controller_Customer extends Controller_Core_Base
{
    public function listAction()
    {
        $model = new Model_Customer();
        $data = $model->fetchAll();

        $this->renderTemplate('customer/list.phtml', [
            'data' => $data
        ]);
    }

    public function editAction()
    {
        $model = new Model_Customer();
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model->load($id);
        }

        $this->renderTemplate('customer/edit.phtml', [
            'data' => $model
        ]);
    }

    public function saveAction()
    {
        $model = new Model_Customer();

        foreach ($_POST['customer'] as $key => $value) {
            $model->$key = $value;
        }

        $pk = $model->getPrimaryKey();
        $id = $model->$pk;

        if ($id) {
            $existing = new Model_Customer();
            $existing->load($id);

            if (!$existing->$pk) {
                throw new Exception('Customer not found for update.');
            }
        } else {
            // New record, continue.
        }

        $model->save();

        $this->redirect('list', 'customer');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model = new Model_Customer();
            $model->load($id);
            $pk = $model->getPrimaryKey();

            if (!$model->$pk) {
                throw new Exception('Customer not found for delete.');
            } else {
                $model->delete();
            }
        } else {
            throw new Exception('Missing customer id.');
        }

        $this->redirect('list', 'customer');
    }
}
