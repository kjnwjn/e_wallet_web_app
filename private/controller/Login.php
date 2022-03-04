<?php

class Login extends Controller
{
    function default()
    {
        $this->view('Layout', array(
            'title' => 'Login',
            'page' => 'login'
        ));
    }
}
