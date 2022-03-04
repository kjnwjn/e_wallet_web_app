<?php

class About extends Controller
{
    function default()
    {
        $this->view('Layout', array(
            'title' => 'About',
            'page' => 'about'
        ));
    }
}
