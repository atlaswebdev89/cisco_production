<?php

namespace Interfaces;

interface Observer {
    public function update(Observable $subject);
}
