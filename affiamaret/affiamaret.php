<?php
/**
 * Plugin Name: Affiamaret
 * Plugin URI: https://www.bungrahman.com/affiamaret
 * Description: Plugin untuk menampilkan daftar produk Affiamaret.
 * Version: 1.0.0
 * Author: Abdul Rahman
 * Author URI: https://www.bungrahman.com/
 * License: GPL2
 */

 // Add license settings section and fields
function affiamaret_license_settings() {
    add_settings_section( 'affiamaret_license_section', 'License Settings', 'affiamaret_license_section_callback', 'affiamaret-settings' );
    add_settings_field( 'affiamaret_license_key', 'License Key', 'affiamaret_license_key_callback', 'affiamaret-settings', 'affiamaret_license_section' );
    register_setting( 'affiamaret_license_options', 'affiamaret_license_key', 'affiamaret_license_sanitize' );
}

// License section callback
function affiamaret_license_section_callback() {
    echo '<p>Enter your license key to activate the plugin.</p>';
}

// License key field callback
function affiamaret_license_key_callback() {
    $license_key = get_option( 'affiamaret_license_key' );
    echo '<input type="text" name="affiamaret_license_key" value="' . esc_attr( $license_key ) . '" />';
}

// Sanitize license key input
function affiamaret_license_sanitize( $license_key ) {
    // Get site URL and MD5 hash it
    $site_url = get_site_url();
    $site_url_md5 = md5( $site_url );

    // Validate license key with site URL
    $valid_license_key = ( $site_url_md5 === $license_key );

    if ( $valid_license_key ) {
        return $license_key;
    } else {
        add_settings_error( 'affiamaret_license_key', 'invalid_license_key', 'Invalid license key.' );
        return get_option( 'affiamaret_license_key' );
    }
}
// Add license settings
add_action( 'admin_init', 'affiamaret_license_settings' );


// Membuat menu Pengaturan Plugin di menu utama
function affiamaret_add_plugin_menu() {
    add_menu_page(
        'Affiamaret Plugin', // Judul halaman
        'Affiamaret Plugin', // Nama menu
        'manage_options', // Akses yang dibutuhkan untuk melihat menu
        'affiamaret-settings', // Slug menu
        'affiamaret_settings_page', // Fungsi untuk menampilkan halaman pengaturan plugin
        'dashicons-admin-settings', // Icon untuk menu
        99 // Urutan menu
    );
}
add_action( 'admin_menu', 'affiamaret_add_plugin_menu' );


function affiamaret_settings_page() {
    ?>
    <div class="wrap">
        <h2>Pengaturan Affiamaret</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'affiamaret-settings-group' ); ?>
            <?php do_settings_sections( 'affiamaret-settings' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function affiamaret_register_settings() {
    register_setting( 'affiamaret-settings-group', 'affiamaret_store_name' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_store_image' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_shopee_enabled' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_tokopedia_enabled' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_bukalapak_enabled' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_lazada_enabled' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_whatsapp_number' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_whatsapp_button' );
    register_setting( 'affiamaret-settings-group', 'affiamaret_checkout_button' );

    add_settings_section( 'affiamaret-section-1', 'Pengaturan Umum', 'affiamaret_section_1_callback', 'affiamaret-settings' );
    add_settings_field( 'affiamaret-store-name', 'Nama Toko', 'affiamaret_store_name_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-store-image', 'Gambar Toko', 'affiamaret_store_image_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-shopee-enabled', 'Shopee', 'affiamaret_shopee_enabled_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-tokopedia-enabled', 'Tokopedia', 'affiamaret_tokopedia_enabled_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-bukalapak-enabled', 'BukaLapak', 'affiamaret_bukalapak_enabled_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-lazada-enabled', 'Lazada', 'affiamaret_lazada_enabled_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-whatsapp-number', 'Nomor Whatsapp', 'affiamaret_whatsapp_number_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-whatsapp-button', 'Tombol Whatsapp', 'affiamaret_whatsapp_button_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    add_settings_field( 'affiamaret-checkout-button', 'Tombol Checkout Woocommerce', 'affiamaret_checkout_button_callback', 'affiamaret-settings', 'affiamaret-section-1' );
    }
add_action( 'admin_init', 'affiamaret_register_settings' );

function affiamaret_section_1_callback() {
    echo '<p>Pengaturan umum plugin Affiamaret.</p>';
}

function affiamaret_store_name_callback() {
    $store_name = get_option( 'affiamaret_store_name' );
    echo '<input type="text" name="affiamaret_store_name" value="' . esc_attr( $store_name ) . '">';
}

function affiamaret_store_image_callback() {
    $store_image = get_option( 'affiamaret_store_image' );
    echo '<input type="text" name="affiamaret_store_image" value="' . esc_attr( $store_image ) . '">';
    echo '<p>Masukkan URL gambar dari library image Woocommerce.</p>';
}

function affiamaret_shopee_enabled_callback() {
    $shopee_enabled = get_option( 'affiamaret_shopee_enabled' );
    echo '<input type="checkbox" name="affiamaret_shopee_enabled" value="1" ' . checked( 1, $shopee_enabled, false ) . '>';
}

function affiamaret_tokopedia_enabled_callback() {
    $tokopedia_enabled = get_option( 'affiamaret_tokopedia_enabled' );
    echo '<input type="checkbox" name="affiamaret_tokopedia_enabled" value="1" ' . checked( 1, $tokopedia_enabled, false ) . '>';
}

function affiamaret_bukalapak_enabled_callback() {
    $bukalapak_enabled = get_option( 'affiamaret_bukalapak_enabled' );
    echo '<input type="checkbox" name="affiamaret_bukalapak_enabled" value="1" ' . checked( 1, $bukalapak_enabled, false ) . ' disabled>';
}

function affiamaret_lazada_enabled_callback() {
    $lazada_enabled = get_option( 'affiamaret_lazada_enabled' );
    echo '<input type="checkbox" name="affiamaret_lazada_enabled" value="1" ' . checked( 1, $lazada_enabled, false ) . ' disabled>';
}

function affiamaret_whatsapp_number_callback() {
    $whatsapp_number = get_option( 'affiamaret_whatsapp_number' );
    echo '<input type="text" name="affiamaret_whatsapp_number" value="' . esc_attr( $whatsapp_number ) . '">';
    echo '<p>Masukkan nomor Whatsapp yang akan ditampilkanpada tombol Whatsapp.</p>';
}

function affiamaret_whatsapp_button_callback() {
$whatsapp_button = get_option( 'affiamaret_whatsapp_button' );
echo '<input type="radio" name="affiamaret_whatsapp_button" value="show" ' . checked( 'show', $whatsapp_button, false ) . '> Tampilkan tombol Whatsapp<br>';
echo '<input type="radio" name="affiamaret_whatsapp_button" value="hide" ' . checked( 'hide', $whatsapp_button, false ) . '> Sembunyikan tombol Whatsapp<br>';
}

function affiamaret_checkout_button_callback() {
$checkout_button = get_option( 'affiamaret_checkout_button' );
echo '<input type="radio" name="affiamaret_checkout_button" value="hide" ' . checked( 'hide', $checkout_button, false ) . '> Sembunyikan tombol Checkout Woocommerce<br>';
echo '<input type="radio" name="affiamaret_checkout_button" value="show" ' . checked( 'show', $checkout_button, false ) . '> Tampilkan tombol Checkout Woocommerce<br>';
}


// Add custom field when Tokopedia is enabled
function affiamaret_add_custom_field() {
    $tokopedia_enabled = get_option( 'affiamaret_tokopedia_enabled' );
    if ( $tokopedia_enabled == 'on' ) {
        global $woocommerce, $post;
        echo '<div class="options_group">';
        woocommerce_wp_text_input(
            array(
                'id' => '_affiamaret_tokopedia_link',
                'label' => __( 'Link Tokopedia', 'woocommerce' ),
                'placeholder' => '',
                'description' => __( 'Masukkan link Tokopedia', 'woocommerce' ),
            )
        );
        echo '</div>';
    }
}
add_action( 'woocommerce_product_options_general_product_data', 'affiamaret_add_custom_field' );

// Save custom field value when product is saved
function affiamaret_save_custom_field( $post_id ) {
    $tokopedia_enabled = get_option( 'affiamaret_tokopedia_enabled' );
    if ( $tokopedia_enabled == 'on' ) {
        $link = isset( $_POST['_affiamaret_tokopedia_link'] ) ? $_POST['_affiamaret_tokopedia_link'] : '';
        update_post_meta( $post_id, '_affiamaret_tokopedia_link', $link );
    }
}
add_action( 'woocommerce_process_product_meta', 'affiamaret_save_custom_field' );

function affiamaret_get_toko_name( $text ) {
    $toko_name = get_option( 'affiamaret_toko_name' );
    $text = str_replace( '{nama_toko}', $toko_name, $text );
    return $text;
}

function affiamaret_get_whatsapp_number( $text ) {
    $whatsapp_number = get_option( 'affiamaret_whatsapp_number' );
    $text = str_replace( '{nomor_whatsapp}', $whatsapp_number, $text );
    return $text;
}

function affiamaret_hide_checkout_button( $purchasable, $product ) {
    $hide_checkout = get_option( 'affiamaret_hide_checkout' );
    if ( $hide_checkout && in_array( $product->get_id(), $hide_checkout ) ) {
        return false;
    }
    return $purchasable;
}

add_filter( 'woocommerce_is_purchasable', 'affiamaret_hide_checkout_button', 10, 2 );

function affiamaret_add_whatsapp_checkout_button() {
    $show_whatsapp_button = get_option( 'affiamaret_show_whatsapp_button' );
    if ( $show_whatsapp_button ) {
        echo '<a href="https://wa.me/'. affiamaret_get_whatsapp_number( get_option( 'affiamaret_whatsapp_number' ) ) .'" class="whatsapp-checkout-button button">'. __( 'Checkout di WhatsApp', 'affiamaret' ) .'</a>';
    }
}

add_action( 'woocommerce_after_add_to_cart_button', 'affiamaret_add_whatsapp_checkout_button' );

function affiamaret_display_marketplace_button() {
    global $product;
    $shopee_link = get_post_meta( $product->get_id(), 'affiamaret_shopee_link', true );
    $tokopedia_link = get_post_meta( $product->get_id(), 'affiamaret_tokopedia_link', true );

    if ( $shopee_link || $tokopedia_link ) {
        echo '<div class="affiamaret-marketplace-buttons">';
        if ( $shopee_link ) {
            echo '<a class="affiamaret-marketplace-button shopee" href="' . $shopee_link . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/shopee.png" /></a>';
        }
        if ( $tokopedia_link ) {
            echo '<a class="affiamaret-marketplace-button tokopedia" href="' . $tokopedia_link . '" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/tokopedia.png" /></a>';
        }
        echo '</div>';
    }
}
add_action( 'woocommerce_after_add_to_cart_button', 'affiamaret_display_marketplace_button' );





function affiamaret_uninstall() {
    delete_option( 'affiamaret_store_name' );
    delete_option( 'affiamaret_store_image' );
    delete_option( 'affiamaret_shopee_enabled' );
    delete_option( 'affiamaret_tokopedia_enabled' );
    delete_option( 'affiamaret_bukalapak_enabled' );
    delete_option( 'affiamaret_lazada_enabled' );
    delete_option( 'affiamaret_whatsapp_number' );
    delete_option( 'affiamaret_whatsapp_button' );
    delete_option( 'affiamaret_checkout_button' );
}
register_uninstall_hook( __FILE__, 'affiamaret_uninstall' );

