<?php
require_once 'app/controllers/Core/Base.php';
require_once 'app/models/Category.php';

class Controller_Category extends Controller_Core_Base
{
    public function listAction()
    {
        $model = new Model_Category();
        $data = $model->fetchAll();

        $this->renderTemplate('category/list.phtml', [
            'data' => $data
        ]);
    }

    public function editAction()
    {
        $model = new Model_Category();
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model->load($id);
        }

        $this->renderTemplate('category/edit.phtml', [
            'data' => $model
        ]);
    }

    public function saveAction()
    {
        $model = new Model_Category();

        foreach ($_POST['category'] as $key => $value) {
            $model->$key = $value;
        }

        $pk = $model->getPrimaryKey();
        $id = $model->$pk;

        if ($id) {
            $existing = new Model_Category();
            $existing->load($id);

            if (!$existing->$pk) {
                throw new Exception('Category not found for update.');
            }
        } else {
            // New record, continue.
        }

        $model->save();

        $this->redirect('list', 'category');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if ($id) {
            $model = new Model_Category();
            $model->load($id);
            $pk = $model->getPrimaryKey();

            if (!$model->$pk) {
                throw new Exception('Category not found for delete.');
            } else {
                $model->delete();
            }
        } else {
            throw new Exception('Missing category id.');
        }

        $this->redirect('list', 'category');
    }
}
