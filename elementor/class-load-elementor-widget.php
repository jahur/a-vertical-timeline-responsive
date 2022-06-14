<?php

namespace AVTLR\Includes\ElementorVtlr;

class Load{

    function __construct(){
        add_action( 'elementor/widgets/register', array($this, 'register_elem_vtlr_widget') );
    }

    public function register_elem_vtlr_widget( $widgets_manager ) {

        require_once( __DIR__ . '/class-elementor-widget-vtlr.php' );
    
        $widgets_manager->register( new \Elementor_Vtlr_Widget() );
    
    }
}