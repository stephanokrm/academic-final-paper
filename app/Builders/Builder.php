<?php

namespace Academic\Builders;

interface Builder { 

    public function create();
    
    public function edit($id);

    public function get();
}
