<?php

namespace Interfaces;

interface Observable {
    public function attach(Observer $observer, $event);
    public function detach(Observer $observer);
    public function notify($event);
}
