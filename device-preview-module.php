<?php

class ET_Builder_Module_By_SJ_Device_Preview extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Device Preview', 'et_builder' );
		$this->slug       = 'et_pb_device_preview';
		$this->fb_support = true;

		$this->whitelisted_fields = array(
			'site_url',
			'frame_style',
			'first_device',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			//'url_new_window'    => array( 'off' ),
			'frame_style' => array( 'light' ),
			'first_device' => array( 'mobile' ),
		);

		$this->main_css_element = '%%order_class%%';

		$this->custom_css_options = array(
			'main_element' => array(
				'label'    => esc_html__( 'Main Element', 'et_builder' ),
				'selector' => '.et_pb_device_preview.et_pb_module',
				'no_space_before_selector' => true,
			),
		);

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'et_builder' ),
					'link'         => esc_html__( 'Link', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'alignment'  => esc_html__( 'Alignment', 'et_builder' ),
					'text'       => array(
						'title'    => esc_html__( 'Text', 'et_builder' ),
						'priority' => 49,
					),
				),
			),
		);

		$this->advanced_options = array(
			'custom_margin_padding' => array(
				'css' => array(
					'main' => "{$this->main_css_element}.et_pb_module, .et_pb_module {$this->main_css_element}.et_pb_module:hover",
					'important' => 'all',
				),
			),
			'filters'               => array(),
		);
	}

	function get_fields() {
		$fields = array(
			'site_url' => array(
				'label'           => esc_html__( 'Site Url', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Add the site you wish to preview.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'frame_style' => array(
				'label'           => esc_html__( 'Mobile Frame Color', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'et_builder' ),
					'dark'  => esc_html__( 'Light', 'et_builder' ),
				),

				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => esc_html__( 'Here you can choose whether your mobile frame should be light or dark. If you are working with a dark background, then your frame should be light. If your background is light, then your frame should be set to dark.', 'et_builder' ),
			),

			'first_device' => array(
				'label'           => esc_html__( 'First Device', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'mobile' => esc_html__( 'Mobile', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop'  => esc_html__( 'Desktop', 'et_builder' ),
				),

				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => esc_html__( 'Choose which device is shown when you fist load the page.', 'et_builder' ),
			),

			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'visibility',
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				'toggle_slug' => 'admin_label',
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);

		return $fields;
	}

	protected function _add_additional_text_shadow_fields() {
		return false;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id         = $this->shortcode_atts['module_id'];
		$module_class      = $this->shortcode_atts['module_class'];
		$site_url        = $this->shortcode_atts['site_url'];
		$frame_style = $this->shortcode_atts['frame_style'];
		$first_device = $this->shortcode_atts['first_device'];

		// Nothing to output if neither Button Text nor Button URL defined
		$site_url = trim( $site_url );

		if ( '' === $button_text && '' === $site_url ) {
			return '';
		}

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$module_class .= " et_pb_module et_pb_bg_layout_{$frame_style}";
		$device_load .= "{$first_device}";

		$output = sprintf(

			'<div id="%2$s" class="et_pb_device_preview_module_wrapper">
			    <div class="device-toggle-div">
			    <ul class="device-toggle-list">
			        <li class="device-toggle"><button class="mobile">Mobile</button></li>
			        <li class="device-toggle"><button class="tablet">Tablet</button></li>
			        <li class="device-toggle"><button class="desktop">Desktop</button></li>
			    </ul>
			    </div>
			    <div class="device-wrapper %4$s %3$s">
                    <div id="device" class="device et_pb_module">
	                    <div class="view">
		                    <iframe class="desktop" src="%1$s"></iframe>
	                    </div>
                    </div>
                    <span class="device-design"></span>
                </div>
            </div>',

			esc_url( $site_url ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $device_load ? sprintf( ' %1$s', esc_attr( $device_load ) ) : '' )
		);

		return $output;
	}

	protected function _add_button_box_shadow_fields( $fields, $option_name, $tab_slug, $toggle_slug ) {
		return false;
	}

	protected function _add_additional_border_fields() {
		return false;
	}

	function process_advanced_border_options( $function_name ) {
		return false;
	}


}

new ET_Builder_Module_By_SJ_Device_Preview;