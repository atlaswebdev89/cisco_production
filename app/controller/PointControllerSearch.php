<?php


namespace Controller;


class PointControllerSearch extends PointController
{
        public function execute($request, $response, $args)
        {
            if ($request->isPost()) {
                $posts_data = $request->getParsedBody();

                if (isset($posts_data['search']) && !empty ($posts_data['search'])) {
                        $data = $this->getData();
                        $data = $data[0];
                    return json_encode($data); exit;
                }
            }
        }

        protected function getData () {
            return $this->model->getDataPoint();
        }
}