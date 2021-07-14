<?php

namespace Controller;
use \Core\Controller\DisplayController;

class PointController extends DisplayController {

    protected $urlPointShow = '/point/show/id/';

    public function execute ($request, $response, $args) {
            return $this->display($request, $response, $args);
    }
    protected function display($request, $response, $args) {
            parent::display($request, $response, $args);
    }
    protected function getGallery() {
        return true;

    }

    //Проверка наличия точки с  указанным id в бд
    protected function checkPoint ($id) {
        return $this->model->checkPoint($id);
    }

    //Формирование массива для передачи в модель для добавления и редактирования в БД
    protected function getdatainBd (array $data) {
                $array['ip']                 =           ip2long($data['ip']);
                $array['id_business']        =           $data['busines'];
                $array['notice']             =           $data['notice'];
                $array['set_place']          =           $data['set_place'];
                $array['speed_download']     =           (float)$data['speed_download'];
                $array['speed_upload']       =           (float)$data['speed_upload'];
                $array['type']               =           $data['type-point'];
                $array['mac']                =           $data['mac_address'];
                $array['installation_date']  =           $data['date'];
                $array['latitude']           =           (float)$data['latitude'];
                $array['longitude']          =           (float)$data['longitude'];
                $array['id_model']           =           (int)$data['model-point'];
                $array['id_ssid']            =           $data['ssid'];
                $array['id_address']         =           $data['address'];
                $array['customer']           =           $data['customer'];
                $array['schema']             =           $data['schema'];
                $array['payment']            =           $data['payment'];
                $array['responsibility']     =           $data['responsibility'];
        return $array;
    }

    //Функция проверки типов данных и формирование правильного массива
    public function CheckTypeGetId (array $posts_data) {
        //Проверка типа для организации
        if (isset($posts_data['busines']) && !empty($posts_data['busines'])) {
            //Проверка типа
            if (filter_var($posts_data['busines'], FILTER_VALIDATE_INT)) {
                //Проверяем есть ли таблице организация с указаным id
                if ($this->model->getBusinesForId((int)$posts_data['busines'])) {
                    $posts_data['busines'] = (int)$posts_data['busines'];
                } else {
                    goto a;
                }
            } else {
                a:
                if (!($getDataBusines = $this->model->getBusines($posts_data['busines']))) {
                    $id_busines = $this->model->addBusines($posts_data['busines']);
                    $posts_data['busines'] = (int)$id_busines;
                } else {
                    $posts_data['busines'] = (int)$getDataBusines[0]['id'];
                }
            };

        }


        //Проверка типа для названия сети точки доступа
        if (isset($posts_data['ssid']) && !empty($posts_data['ssid'])) {
            //Проверка типа
            if (filter_var($posts_data['ssid'], FILTER_VALIDATE_INT)) {
                //Проверяем есть ли таблице название сети с указаным id
                if ($this->model->getSsidForId((int)$posts_data['ssid'])) {
                    $posts_data['ssid'] = (int)$posts_data['ssid'];
                } else {
                    goto b;
                }

            } else {
                b:
                if (!($getDataSsid = $this->model->getSsid($posts_data['ssid']))) {
                    $id_ssid = $this->model->addSsid($posts_data['ssid']);
                    $posts_data['ssid'] = (int)$id_ssid;
                } else {
                    $posts_data['ssid'] = (int)$getDataSsid[0]['id'];
                }
            };

        }

        //Проверка типа для адреса точки доступа
        if (isset($posts_data['address']) && !empty($posts_data['address'])) {
            if (!($getDataAddress = $this->model->getAddress($posts_data['address']))) {
                $id_address = $this->model->addAddress($posts_data['address']);
                $posts_data['address'] = (int)$id_address;
            } else {
                $posts_data['address'] = (int)$getDataAddress[0]['id'];
            }
        }else {
            $posts_data['address'] = NULL;
        };
        return $posts_data;
    }


    
    
}
