<?php

class Home extends Controller
{
    function default()
    {
        $this->view('Layout', array(
            'title' => 'Home',
            'page' => 'home'
        ));
    }
}
