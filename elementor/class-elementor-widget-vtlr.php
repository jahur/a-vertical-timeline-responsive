<?php


class Elementor_Vtlr_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ttq_vtlr';
	}

	public function get_title() {
		return esc_html__( 'Vertical timeline', 'avtlr' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'timeline', 'vertical', 'vertical timeline', 'list' ];
	}

	public function __construct( $data=[], $args=null ){

        parent::__construct( $data, $args );

        wp_register_style( 'vtlr-css', AVTLR_URL . 'includes/public/css/vertical-timeline-style.css', '', time() );

    }

	public function get_style_depends() {
	
		return [ 'vtlr-css' ];
	
	}

	protected function register_controls() {

		// Content Tab Start

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'avtlr' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'vtlr_dateortext', [
				'label' => esc_html__( 'Date/Text', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Title' , 'avtlr' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'vtlr_title', [
				'label' => esc_html__( 'Title', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Title' , 'avtlr' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'vtlr_content', [
				'label' => esc_html__( 'Content', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Description' , 'avtlr' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'vtlr',
			[
				'label' => esc_html__( 'Timeline List', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ vtlr_title }}}',
			]
		);

		$this->end_controls_section();

		// Content Tab End

		// Style Tab Start

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'avtlr' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'vertical_bar_color',
			[
				'label' => esc_html__( 'Vertical Bar Color', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avtlr-timeline::after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .avtlr-container::after' => 'border: 2px solid {{VALUE}};',
				],
                'default' => '#C95B5B',
			]
		);

		$this->add_control(
			'card_background_color',
			[
				'label' => esc_html__( 'Card Background Color', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avtlr-container .content' => 'background-color: {{VALUE}};',
				],
                'default' => '#DED5D5',
			]
		);

        $this->add_control(
			'datetext_color',
			[
				'label' => esc_html__( 'Date/Text Color', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avtlr-container .date' => 'color: {{VALUE}};',
				],
                'default' => '#843434',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avtlr-container .content h2' => 'color: {{VALUE}};',
				],
                'default' => '#000000',
			]
		);

        $this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'avtlr' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avtlr-container .content p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .avtlr-container .content a' => 'color: {{VALUE}};',
				],
                'default' => '#000000',
			]
		);

		$this->end_controls_section();

		// Style Tab End

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['vtlr'] ) {
			echo '<div class="avtlr-timeline">';

			foreach (  $settings['vtlr'] as $key=>$item ) {

                if($key % 2 == 0){  $phase = "left";  } else{ $phase = "right";  }
                //var_dump($item);
                echo '<div class="avtlr-container '. $phase .'">';
                echo '<div class="date">' . $item['vtlr_dateortext'] . '</div>';
                    // <i class="icon fa fa-gift"></i>
                echo '<div class="content">';
                echo '<h2>'. $item['vtlr_title'] .'</h2>';
                echo '<p>';
                echo $item['vtlr_content'];
                echo '</p>';
                echo '</div>';
                echo '</div>';

			}
			echo '</div>';
		}
	}

	protected function content_template() {
		
	}

}