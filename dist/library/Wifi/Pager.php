<?php


namespace Wifi;


use mysql_xdevapi\Result;

class Pager
{

        protected $driver;
        protected $totalCount;
        protected $page;
        protected $dataArray;
        protected $field;
        protected $tablename;
        protected $where;
        protected $join = FALSE;
        protected $group = FALSE;

        //Количество точек на одной странице пагинации, задается константой
        protected $post_number;

        protected $number_link;

        public function __construct($driver)
        {
            $this->driver = $driver;
        }

        public function setData (array $data) {
                $this->page         =   $data['page'];
                $this->fields        =  $data['fields'];
                $this->tablename    =   $data['tablename'];
                $this->join         =   $data['join'];
                $this->where        =   $data['where'];
                $this->order        =   $data['order'];
                $this->post_number  =   $data['post_number'];
                $this->number_link  =   $data['number_link'];
        }
        
        public function setDataArray (array $data) {
                $this->page         =   $data['page'];              
                $this->post_number  =   $data['post_number'];
                $this->number_link  =   $data['number_link'];
                $this->dataArray    =   $data['data'];
        }
        
        public function get_total_array() {
            $this->totalCount = count($this->dataArray);
        }
        
        public function getItemArray () {
            
             //Общее количество результатов поиска
            $total_post = $this->get_total_array();
            //Количество страниц пагинации для отображения всех точек
            $number_pages =(int)($total_post/$this->post_number);
            
            if (($total_post%$this->post_number)!= 0) {
                $number_pages++;
            }
            
            $start = ($this->page-1)*$this->post_number;
            return $result = array_slice($this->dataArray, $start, $this->post_number );
        }

        //Функция получения общего количества точек доступа, с учетом условия
        public function get_total () {

            if($this->totalCount) {
                return $this->totalCount;
            }

            $sql ="SELECT COUNT(*) as count FROM ". $this->tablename;
            if ($this->where) {
                $sql .= ' WHERE '.$this->where;
            }

                $type = "arraydata";
                $result = $this->driver->query($sql, $type);
                $this->totalCount = $result[0]['count'];
            return $this->totalCount;
        }

        public function get_posts ( ) {

            //Общее количество точек wifi
            $total_post = $this->get_total();

            //Количество страниц пагинации для отображения всех точек
            $number_pages =(int)($total_post/$this->post_number);

            if (($total_post%$this->post_number)!= 0) {
                $number_pages++;
            }

            $start = ($this->page-1)*$this->post_number;
            $sql = "SELECT ".$this->fields." FROM ". $this->tablename;

            if ($this->join) {
                $sql.=$this->join;
            }
            if ($this->where) {
                $sql.=" WHERE ".$this->where;
            }
            if ($this->order) {
                $sql.=$this->order;
            }

            $sql.=" LIMIT ".$start.",".$this->post_number;

                    $type = "arraydata";
                    $result = $this->driver->query($sql, $type);
                return $result;
        }

        public function get_navigation () {

            $result = array();
            //Общее количество точек wifi
            $total_post = $this->get_total();
            //Количество страниц пагинации для отображения всех точек
            $number_pages =(int)($total_post/$this->post_number);

            if (($total_post%$this->post_number)!= 0) {
                $number_pages++;
            }

            if($total_post <= $this->post_number || $this->page > $number_pages) {
                return FALSE;
            }

            if ($this->page != 1 ) {
                $result['first'] = 1;
                $result['last_page'] = $this->page - 1;
            }

            if ($this->page > $this->number_link + 1 ){
                for($i = $this->page - $this->number_link; $i<$this->page; $i++){
                    $result['previous'][] = $i;
                }
            }else {
                for($i = 1; $i<$this->page; $i++){
                    $result['previous'][] = $i;
                }
            }

            $result['current'] = $this->page;

            if ($this->page+$this->number_link < $number_pages){
                for ($i=$this->page+1; $i <= $this->page+$this->number_link; $i++){
                    $result['next'][] = $i;
                }
            }else {
                for ($i=$this->page+1; $i<=$number_pages; $i++){
                    $result['next'][]=$i;
                }
            }
            if ($this->page != $number_pages){
                $result['next_pages'] = $this->page+1;
                $result['end'] = $number_pages;
            }

            return $result;

        }
        public function getItems () {
                $result = array();
                $result['items'] = $this->get_posts();
                $result['navigation'] = $this->get_navigation();
           return $result;


        }
        
        public function getItemsArrayData () {
                $result =array ();
                $result['items'] = $this->getItemArray();
                $result['navigation'] = $this->get_navigation();
           return $result; 
        }
}