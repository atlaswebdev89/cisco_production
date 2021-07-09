<?php


namespace Controller;


class PointControllerDelete extends PointController
{
    public function execute ($request, $response, $args) {
        if ($request->isPost()) {
            //Получение POST данных
            $posts_data = $request->getParsedBody();
            if (isset($posts_data['id']) && !empty ($posts_data['id'])) {
                    //Приведение к integer
                    $id = (int)$posts_data['id'];
            }
            //Проверяеям есть ли точка с указаным id в бд
            if($this->model->checkPoint($id)) {
                //Если есть удаляем её из базы
               if($this->model->deletePoint($id)) {
                   return $response->withJson(array('status'=> TRUE, 'url' => '/point'));
               }else return $response->withJson(array('status'=> FALSE));;
            }else return $response->withJson(array('status'=> 'NotFoundPoint'));
        }
    }
}