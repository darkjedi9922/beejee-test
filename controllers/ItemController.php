<?php namespace controllers;

use base\Controller;
use models\TodoItemModel;
use base\Auth;

class ItemController extends Controller
{
    const ADD_ERRORS_COOKIE = 'add-errors';
    
    public function actionAdd()
    {
        $item = new TodoItemModel;
        $item->username = $_POST['username'] ?? '';
        $item->email = $_POST['email'] ?? '';
        $item->text = $_POST['text'] ?? '';
        
        $errors = $item->addItemFromPost($_POST);
        if (!empty($errors)) $this->saveErrorsAndGoBack(self::ADD_ERRORS_COOKIE, $errors);

        // There are no errors, then save ERROR_ALL_OK for callback.
        $this->saveErrorsAndGoBack(self::ADD_ERRORS_COOKIE, [TodoItemModel::ERROR_ALL_OK]);
    }

    public function actionEdit(int $id)
    {
        if (!(new Auth)->isLogged()) { 
            http_response_code(403);
            return;
        }

        $model = new TodoItemModel;
        if (($status = $_POST['status'] ?? null) !== null)
            $model->updateStatus($id, $status);
        
        if (($newText = $_POST['text'] ?? null) !== null)
            $model->updateText($id, $newText);
    }
}