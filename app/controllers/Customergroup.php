<?php
require_once 'app/controllers/Core/Base.php';
require_once 'app/models/Customergroup.php';

class Controller_Customergroup extends Controller_Core_Base
{
    public function listAction()
    {
        $model = new Model_Customergroup();
        $data = $model->fetchAll();

        $this->renderTemplate('customergroup/list.phtml', [
            'data' => $data
        ]);
    }

    public function editAction()
    {
        $model = new Model_Customergroup();
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model->load($id);
        }

        $this->renderTemplate('customergroup/edit.phtml', [
            'data' => $model
        ]);
    }

    public function saveAction()
    {
        $model = new Model_Customergroup();

        foreach ($_POST['customergroup'] as $key => $value) {
            $model->$key = $value;
        }

        $pk = $model->getPrimaryKey();
        $id = $model->$pk;

        if ($id) {
            $existing = new Model_Customergroup();
            $existing->load($id);

            if (!$existing->$pk) {
                throw new Exception('Customer group not found for update.');
            }
        } else {
            // New record, continue.
        }

        $model->save();

        $this->redirect('list', 'customergroup');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model = new Model_Customergroup();
            $model->load($id);
            $pk = $model->getPrimaryKey();

            if (!$model->$pk) {
                throw new Exception('Customer group not found for delete.');
            } else {
                $model->delete();
            }
        } else {
            throw new Exception('Missing customer group id.');
        }

        $this->redirect('list', 'customergroup');
    }
}
