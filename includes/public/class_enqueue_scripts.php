<?php

namespace AVTLR\Includes\Public;

class Enqueue_Scripts{

    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
    }

    public function enqueue_scripts(){

       wp_enqueue_style( 'vertical-timeline-style', plugins_url( '/css/vertical-timeline-style.css', __FILE__ ), array(), time() );
    
    }
}