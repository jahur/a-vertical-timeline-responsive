<?php

namespace AVTLR\Includes\Public;

class Shortcode{

    function __construct(){
        add_shortcode( 'vtimeline', array($this, 'vtimeline_shortcode') );
    }

    public function vtimeline_shortcode( $atts ) {

        $params = shortcode_atts( array(
            'id' => '',
        ), $atts ); 
   
        ob_start(); 

        // The Query
        if(!$params['id']):

           echo 'Add id attribute to vertical timeline shortcode';

        else:

            $id = (int) $params['id'];

            $this->vertical_timeline_template($id);

        endif;

        return ob_get_clean();
    }

    public function vertical_timeline_template($id){ 
        $post_meta = get_post_meta( $id, 'vtlr_group_demo' );
        $vtlr_color_meta1 = get_post_meta( $id, 'vtlr_settings_colorpickerone' );
        $vtlr_color_meta2 = get_post_meta( $id, 'vtlr_settings_colorpickertwo' );
        $vtlr_color_datetext = get_post_meta( $id, 'vtlr_settings_color_datetext' );
        $vtlr_color_title = get_post_meta( $id, 'vtlr_settings_color_title' );
        $vtlr_color_desc = get_post_meta( $id, 'vtlr_settings_color_desc' );
        

        $color1 = ($vtlr_color_meta1) ? $vtlr_color_meta1[0] : '#ffffff';
        
        if($vtlr_color_meta2)
        $color2 = $vtlr_color_meta2[0];
        else
        $color2 = '#ffffff';

        if($vtlr_color_datetext)
        $color_datetext = $vtlr_color_datetext[0];
        else
        $color_datetext = '#000000';

        if($vtlr_color_title)
        $color_title = $vtlr_color_title[0];
        else
        $color_title = '#000000';

        if($vtlr_color_desc)
        $color_desc = $vtlr_color_desc[0];
        else
        $color_desc = '#000000';

        ?>
        <style>
            .avtlr-container.left::before,
            .avtlr-container.right::before {
                border-color: transparent <?php echo $color1; ?> transparent transparent;
            }
            .avtlr-container .content h2 {
                color: <?php echo $color_title; ?>;
            }
            .avtlr-container .content {
                background: <?php echo $color2; ?>;
            }
            .avtlr-container .content p{
                color: <?php echo $color_desc; ?>
            }
            .avtlr-container .icon {
                background: <?php echo $color2; ?>;
                border: 2px solid <?php echo $color1; ?>;
                color: <?php echo $color1; ?>;
            }
            .avtlr-container .date {
                color: <?php echo $color_datetext; ?>;
            }
            .avtlr-container.left::before{
                border: medium solid <?php echo $color2; ?>;
                border-color: transparent transparent transparent <?php echo $color2; ?>;
            }
            .avtlr-container.right::before {
                border: medium solid <?php echo $color2; ?>;
                border-color: transparent <?php echo $color2; ?> transparent transparent;
            }
            .avtlr-container::after {
                border: 2px solid <?php echo $color1; ?>;
            }
            .avtlr-timeline::after {
                background: <?php echo $color1; ?>;
            }
        </style>
    
        <?php
        if( !empty($post_meta) ):
            echo '<div class="avtlr-timeline">';
            foreach( $post_meta[0] as $key=>$value ){ 
                
                if($key % 2 == 0){  $phase = "left";  } else{ $phase = "right";  }
                
                ?>
                <div class="avtlr-container <?php echo $phase; ?>">
                    <div class="date"><?php echo $value['dateortext']; ?></div>
                    <!-- <i class="icon fa fa-gift"></i> -->
                    <div class="content">
                    <h2><?php echo $value['title']; ?></h2>
                    <p>
                    <?php echo $value['textarea1']; ?>
                    </p>
                    </div>
                </div>
           <?php }
        endif;
        echo '</div>';
        ?>

    <?php
    }
}