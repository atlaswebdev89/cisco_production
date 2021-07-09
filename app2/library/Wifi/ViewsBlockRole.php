<?php


namespace Wifi;


class ViewsBlockRole
{
    public $array = array();

    public function getShowBlock($role)
    {
        switch ($role) {
            case 'admin' :
                $this->array = [
                    'show_block_admin'      => TRUE,
                    'show_block_moderator'  => TRUE
                ];
                return $this->array;
            case 'moderator':
                $this->array = [
                    'show_block_admin'      => FALSE,
                    'show_block_moderator'  => TRUE
                ];
                return $this->array;
            case 'user':
                $this->array = [
                    'show_block_admin'      => FALSE,
                    'show_block_moderator'  => FALSE
                ];
                return $this->array;
                break;
        }
    }
}