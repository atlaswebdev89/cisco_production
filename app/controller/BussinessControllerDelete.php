<?php


namespace Controller;


class BussinessControllerDelete extends BussinessController
{
    public function execute ($request, $response, $args) {
        if ($request->isPost()) {
            //Получение POST данных
            $posts_data = $request->getParsedBody();
            if (isset($posts_data['id']) && !empty ($posts_data['id'])) {
                //Приведение к integer
                $id = (int)$posts_data['id'];
            }
            //Проверяеям организация с указаным id в бд
            if($this->model->checkBussiness($id)) {
                //Если есть удаляем её из базы
                if($this->model->deleteBussiness($id)) {
                    return $response->withJson(array('status'=> TRUE, 'url' => '/bussiness'));
                }else return $response->withJson(array('status'=> FALSE));;
            }else return $response->withJson(array('status'=> 'NotFoundPoint'));
        }
    }
}