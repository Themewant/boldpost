<?php
namespace BoldPo\Tracking;

use Appsero\Client;

if ( ! defined( 'ABSPATH' ) ) exit;

class Appsero_Tracker {

    private static $instance = null;
    private $client;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init();
    }

    private function init() {

        // Appsero Client init
        $this->client = new Client(
            '528c40ac-37ea-4f2b-8db7-1f0984f46d0a',
            'BoldPost',
            BOLDPO_PL_ROOT
        );

        $this->client->set_textdomain( 'boldpost' );

        $this->client->insights()
            ->add_plugin_data()
        ->add_extra( $this->extra_data() )
        ->init();
        
    }

    private function extra_data() {
        return [
            'is_pro_active' => defined( 'BOLDPO_PRO_VERSION' ) ? 'Yes' : 'No',
            'pro_version'   => defined( 'BOLDPO_PRO_VERSION' ) ? BOLDPO_PRO_VERSION : '',
        ];
    }
}