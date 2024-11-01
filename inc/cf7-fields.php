<?php

if(!defined("ABSPATH"))die;

function tgc_editor_panel_conditional($form) {

	if(isset($_GET['post'])){
		$form_id = $_GET['post'];
		$wpcf7_meta = get_post_meta($form_id);
    }
    else{
	    $wpcf7_meta = [];
    }


	?>
    <div id="wpcf7tgc-text-entries">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label><?=__("Bot Token (optional, default is set in plugin options)","easy-telegram-connector")?></label>
                </th>
                <td>
                    <input type="text" name="tgc-token" class="large-text code" size="70" value="<?= isset($wpcf7_meta['tgc-token']) && $wpcf7_meta['tgc-token'][0] ? $wpcf7_meta['tgc-token'][0] : "" ?>">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label><?=__("Chat ID (optional, default is set in plugin options)","easy-telegram-connector")?></label>
                </th>
                <td>
                    <input type="text" name="tgc-chatid" class="large-text code" size="70" value="<?= isset($wpcf7_meta['tgc-chatid']) && $wpcf7_meta['tgc-chatid'][0] ? $wpcf7_meta['tgc-chatid'][0] : "" ?>">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label><?=__("Template (insert form fields as %field-name%)","easy-telegram-connector")?></label>
                </th>
                <td>
                    <textarea name="tgc-template" cols="100" rows="6" class="large-text code"><?= isset($wpcf7_meta['tgc-template']) && $wpcf7_meta['tgc-template'][0] ? $wpcf7_meta['tgc-template'][0] : "" ?></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
	<?php
}

class TGC_CF7_Fields{

    public function __construct() {
	    // add the action
	    add_action( 'wpcf7_save_contact_form', [$this,'save_contact_form'], 10, 1 );
	    add_filter('wpcf7_editor_panels', [$this,'add_conditional_panel']);
    }

	public function add_conditional_panel($panels) {
		$panels['contitional-panel'] = array(
			'title' => __( 'Telegram Connector', "easy-telegram-connector" ),
			'callback' => 'tgc_editor_panel_conditional'
		);
		return $panels;
	}


	public function save_contact_form( $contact_form ) {

		if ( ! isset( $_POST ) || empty( $_POST ) || (! isset( $_POST['tgc-token'] ) || ! isset( $_POST['tgc-chatid'] ) || ! isset( $_POST['tgc-template'] ) ) )
			return;
		$post_id = $contact_form->id();
		if ( ! $post_id )
			return;

        $options = ['tgc-token','tgc-chatid','tgc-template'];

        foreach($options as $option):
            if(isset($_POST[$option]))
                update_post_meta($post_id, $option, sanitize_text_field($_POST[$option]));
        endforeach;

		return;

	}

}


add_action('init','tgс_cf7_fields');

function tgс_cf7_fields(){
    $tgcf7_fields = new TGC_CF7_Fields();
}