<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('Wext_Wc_Product_Tab' ) ):
class Wext_Wc_Product_Tab {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'woocommerce', 'Tabs by Category', 'Tabs by Category', 'manage_options', 'wext_wc_tab_settings', array($this, 'plugin_page'), 'dashicons-editor-table', '55.7' );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'wext_wcpt_settings',
                'title' => __( 'Tab Settings', 'wexteam' )
            ),
            array(
                'id' => 'wext_wcpt_style',
                'title' => __( 'Tab Style', 'wexteam' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wext_wcpt_settings' => array(
                array(
                    'name'              => 'wext_wcpt_tab_number',
                    'label'             => __( 'Tab Number', 'wexteam' ),
                    'desc'              => __( 'You can set how many tab show in tab panel. Default is 5 tab', 'wexteam' ),
                    'type'              => 'number',
                    'default'           => '5',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'wext_wcpt_column_number',
                    'label'             => __( 'Columns', 'wexteam' ),
                    'desc'              => __( 'You can set how many columns of products to show. Default is 4 columns', 'wexteam' ),
                    'type'              => 'number',
                    'default'           => '4',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'wext_wcpt_product_number',
                    'label'             => __( 'Products Per Tab', 'wexteam' ),
                    'desc'              => __( 'You can set how many product show under a tab. Default is 4 product', 'wexteam' ),
                    'type'              => 'number',
                    'default'           => '4',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'    => 'wext_wcpt_product_orderby',
                    'label'   => __( 'Product Orderby', 'wexteam' ),
                    'desc'    => __( 'You can chose product showing orderby. Default is Name Orderby ', 'wexteam' ),
                    'type'    => 'select',
                    'options' => array(
                        'name'      => 'Name',
                        'date'      => 'Date',
                        'modified'  => 'Modified',
                        'rand'      => 'Random '
                    ),
                    'default' => 'fade',
                ),
                array(
                    'name'    => 'wext_wcpt_product_order',
                    'label'   => __( 'Product Order', 'wexteam' ),
                    'desc'    => __( 'You can chose product showing order. Default is Ascending order', 'wexteam' ),
                    'type'    => 'radio',
                    'options' => array(
                        'ASC' => 'Ascending ',
                        'DESC'=> 'Descending '
                    ),
                    'default' => 'ASC',
                ),
                array(
                    'name'    => 'wext_wcpt_tab_prefix',
                    'label'   => __( 'Tabs Prefix', 'wexteam' ),
                    'desc'    => __( 'Specify a prefix to show before the tabs', 'wexteam' ),
                    'type'    => 'text',
                    'default' => 'Categories:',
                ),
                array(
                    'name'    => 'wext_wcpt_tabs_exclude',
                    'label'   => __( 'Categories to Exclude', 'wexteam' ),
                    'desc'    => __( 'Specify a comma separated list of category IDs to exclude like: 123,908,220', 'wexteam' ),
                    'type'    => 'text',
                    'default' => '',
                )
            ),
            'wext_wcpt_style' => array(
                array(
                    'name'    => 'wext_wcpt_tab_panel_color',
                    'label'   => __( 'Tab panel color', 'wexteam' ),
                    'desc'    => __( 'You can chose tab panel color form here. Defult color is #40403E', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#40403E'
                ),
                array(
                    'name'    => 'wext_wcpt_tab_color',
                    'label'   => __( 'Tab color', 'wexteam' ),
                    'desc'    => __( 'You can chose tab color form here.  Defult color is #FE980F', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#FE980F'
                ),
                array(
                    'name'    => 'wext_wcpt_tab_font_color',
                    'label'   => __( 'Tab Font Color', 'wexteam' ),
                    'desc'    => __( 'You can chose tab font color form here.  Defult color is #B3AFA8', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#B3AFA8'
                ),
                array(
                    'name'    => 'wext_wcpt_tab_font_hover_color',
                    'label'   => __( 'Tab Font Hover Color', 'wexteam' ),
                    'desc'    => __( 'You can chose tab font hover color form here.  Defult color is #FFFFFF', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#FFFFFF'
                ),
                array(
                    'name'    => 'wext_wcpt_pro_price_color',
                    'label'   => __( 'Product price color', 'wexteam' ),
                    'desc'    => __( 'You can chose product price color form here.  Defult color is #FE980F', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#FE980F'
                ),
                array(
                    'name'    => 'wext_wcpt_pro_name_color',
                    'label'   => __( 'Product name color', 'wexteam' ),
                    'desc'    => __( 'You can chose product name color form here.  Defult color is #6E6C68', 'wexteam' ),
                    'type'    => 'color',
                    'default' => '#6E6C68'
                ),
                array(
                    'name'    => 'wext_wcpt_pro_border',
                    'label'   => __( 'Product border', 'wexteam' ),
                    'desc'    => __( 'You can change produc border from here. Defult is Show', 'wexteam' ),
                    'type'    => 'radio',
                    'options' => array(
                        '1' => 'Show',
                        '0'  => 'Hide'
                    ),
                    'default' => '1',
                )
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
