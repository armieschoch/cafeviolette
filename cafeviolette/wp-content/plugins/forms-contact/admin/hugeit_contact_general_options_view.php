<?php
if(! defined( 'ABSPATH' )) exit;
if (function_exists('current_user_can'))
    if (!current_user_can('manage_options')) {
        die('Access Denied');
    }
if (!function_exists('current_user_can')) {
    die('Access Denied');
}
require_once("hugeit_free_version.php");
function hugeit_contact_html_show_settings($param_values) {
    $save_generaloptions_link = admin_url( 'admin.php?page=hugeit_forms_general_options&task=save' );
    $save_generaloptions_link = wp_nonce_url( $save_generaloptions_link, 'hugeit_forms_save_general_options' );

	$path_site = plugins_url("Front_images", __FILE__); ?>
	<div class="wrap">
		<?php hugeit_contact_drawFreeBanner();?>
		<div id="poststuff">
			<div id="post-body-content">
				<div id="post-body-heading">
					<h3><?php _e('General Options', 'hugeit_contact');?></h3>
					<a onclick="document.getElementById('adminForm').submit()" class="save-hugeit_contact-options button-primary">Save</a>
				</div>
				<div class="options-block">
				<form action="<?php echo $save_generaloptions_link;?>" method="post" id="adminForm" name="adminForm">
					<div class="hugeit-contact-general-options-column hugeit-contact-general-options-left">
						<div class="hugeit-contact-general-options-block">
							<h3><?php _e('Your Form Settings', 'hugeit_contact');?></h3>
							<div>
								<label for="form_adminstrator_user_name">
                                    <?php _e('Send Emails From Name', 'hugeit_contact');?>
                                </label>
								<input type="text" id="form_adminstrator_user_name" name="params[form_adminstrator_user_name]" value="<?php echo esc_html($param_values['form_adminstrator_user_name']); ?>" />
							</div>
							<div>
								<label for="form_adminstrator_user_mail">
                                    <?php _e('Send Emails From Email', 'hugeit_contact');?>
                                </label>
								<input type="text" id="form_adminstrator_user_mail" name="params[form_adminstrator_user_mail]" <?php if($param_values['form_save_reply_to_user']  == 'on'){ echo 'readonly="readonly"'; } ?> value="<?php echo esc_html($param_values['form_adminstrator_user_mail']); ?>" />
							</div>
                            <div>
                                <label for="reply_to_user">
                                    <?php _e('Reply To User','hugeit_contact');?>
                                </label>
                                <input type="hidden" value="off" name="params[form_save_reply_to_user]" />
                                <input type="checkbox" id="reply_to_user" name="params[form_save_reply_to_user]" value="on" <?php if($param_values['form_save_reply_to_user']  == 'on'){ echo 'checked="checked"'; } ?>/>
                            </div>
							<div>
								<label for="form_captcha_public_key">
                                    <?php _e('Captcha Public Key', 'hugeit_contact');?>
                                </label>
								<input type="text" id="form_captcha_public_key" name="params[form_captcha_public_key]" value="<?php echo esc_html($param_values['form_captcha_public_key']); ?>" />
							</div>
							<div>
								<label for="form_captcha_private_key">
                                    <?php _e('Captcha Private Key', 'hugeit_contact');?>
                                </label>
								<input type="text" id="form_captcha_private_key" name="params[form_captcha_private_key]" value="<?php echo esc_html($param_values['form_captcha_private_key']); ?>" />
							</div>
							<div>
								<label for="form_save_to_database">
                                    <?php _e('Save Submissions To Database', 'hugeit_contact');?>
                                </label>
								<input type="hidden" value="off" name="params[form_save_to_database]" />
								<input type="checkbox" id="form_save_to_database" <?php if($param_values['form_save_to_database']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_save_to_database]" value="on" />
							</div>
						</div>
						<div class="hugeit-contact-general-options-block brlable" >
							<h3><?php _e('Form Messages', 'hugeit_contact');?></h3>
							<div>
								<label for="msg_send_success">
                                    <?php _e("Sender's message was sent successfully", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_send_success]" type="text" id="msg_send_success" value="<?php echo esc_html($param_values['msg_send_success']); ?>" />
							</div>
							<div>
								<label for="msg_send_false">
                                    <?php _e("Sender's message was failed to send", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_send_false]" type="text" id="msg_send_false" value="<?php echo esc_html($param_values['msg_send_false']); ?>" />
							</div>
							<div>
								<label for="msg_refered_spam">
                                    <?php _e("Submission was referred to as spam", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_refered_spam]" type="text" id="msg_refered_spam" value="<?php echo esc_html($param_values['msg_refered_spam']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_number_smaller">
                                    <?php _e("Number is smaller than minimum limit", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_number_smaller]" type="text" id="msg_number_smaller" value="<?php echo esc_html($param_values['msg_number_smaller']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_number_large">
                                    <?php _e("Number is larger than maximum limit", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_number_large]" type="text" id="msg_number_large" value="<?php echo esc_html($param_values['msg_number_large']); ?>" />
							</div>
							<div>
								<label for="msg_captcha_error">
                                    <?php _e("Captcha is Not Validated", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_captcha_error]" type="text" id="msg_captcha_error" value="<?php echo esc_html($param_values['msg_captcha_error']); ?>" />
							</div>
							<div>
								<label for="required_empty_field">
                                    <?php _e("Required Field Is Empty", 'hugeit_contact');?>
                                </label>
								<input name="params[required_empty_field]" type="text" id="required_empty_field" value="<?php echo esc_html($param_values['required_empty_field']); ?>" />
							</div>
							<div>
								<label for="msg_invalid_email">
                                    <?php _e("Email address that the sender entered is invalid", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_invalid_email]" type="text" id="msg_invalid_email" value="<?php echo esc_html($param_values['msg_invalid_email']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_url">
                                    <?php _e("URL that the sender entered is invalid", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_invalid_url]" type="text" id="msg_invalid_url" value="<?php echo esc_html($param_values['msg_invalid_url']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_tel">
                                    <?php _e("Phone number that the sender entered is invalid", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_invalid_tel]" type="text" id="msg_invalid_tel" value="<?php echo esc_html($param_values['msg_invalid_tel']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_date">
                                    <?php _e("Date format that the sender entered is invalid", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_invalid_date]" type="text" id="msg_invalid_date" value="<?php echo esc_html($param_values['msg_invalid_date']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_early_date">
                                    <?php _e("Date is earlier than minimum limit", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_early_date]" type="text" id="msg_early_date" value="<?php echo esc_html($param_values['msg_early_date']); ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_late_date">
                                    <?php _e("Date is later than maximum limit", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_late_date]" type="text" id="msg_late_date" value="<?php echo esc_html($param_values['msg_late_date']); ?>" />
							</div>
							<div>
								<label for="msg_fail_failed">
                                    <?php _e("Uploading a file fails for any reason", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_fail_failed]" type="text" id="msg_fail_failed" value="<?php echo esc_html($param_values['msg_fail_failed']); ?>" />
							</div>
							<div>
								<label for="msg_file_format">
                                    <?php _e("Uploaded file is not allowed file type", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_file_format]" type="text" id="msg_file_format" value="<?php echo esc_html($param_values['msg_file_format']); ?>" />
							</div>
							<div>
								<label for="msg_large_file">
                                    <?php _e("Uploaded file is too large", 'hugeit_contact');?>
                                </label>
								<input name="params[msg_large_file]" type="text" id="msg_large_file" value="<?php echo esc_html($param_values['msg_large_file']); ?>" />
							</div>
							<div>
								<label for="msg_simple_captcha_error"><?php _e('Simple Captcha Code Incorrect','hugeit_contact');?></label>
								<input name="params[msg_simple_captcha_error]" type="text" id="msg_simple_captcha_error" value="<?php echo esc_html($param_values['msg_simple_captcha_error']); ?>" />
							</div>
						</div>
					</div>
					<div class="hugeit-contact-general-options-column hugeit-contact-general-options-right">
						<div class="hugeit-contact-general-options-block">
							<h3><?php _e("Email To Administrator", 'hugeit_contact');?></h3>
							<div>
								<label for="form_send_email_for_each_submition">
                                    <?php _e("Send Email For Each Submission", 'hugeit_contact');?>
                                </label>
								<input type="hidden" value="off" name="params[form_send_email_for_each_submition]" />
								<input type="checkbox" id="form_send_email_for_each_submition"  <?php if($param_values['form_send_email_for_each_submition']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_send_email_for_each_submition]" value="on" />
							</div>
							<div>
								<label for="form_adminstrator_email">
                                    <?php _e("Administrator Email", 'hugeit_contact');?>
                                </label>
								<input type="text" id="form_adminstrator_email" name="params[form_adminstrator_email]" value="<?php echo esc_html($param_values['form_adminstrator_email']); ?>" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="Add multiple emails separating them with commas.">?</dfn>
							</div>
							<div>
								<label for="form_message_subject">
                                    <?php _e("Message Subject", 'hugeit_contact');?>
                                </label>
								<input name="params[form_message_subject]" type="text" class="" id="form_message_subject" value="<?php echo esc_html($param_values['form_message_subject']); ?>" size="10" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="If you leave this field empty, the name of the submitted form will be used as the subject of the email.">?</dfn>
							</div>
							<div class="autoheight">
								<label for="form_adminstrator_message">
                                    <?php _e("Message", 'hugeit_contact');?>
                                </label>
								<?php
								function hugeit_contact_wptiny($initArray){
									$initArray['height'] = '300px';
									$initArray['forced_root_block'] = false;
									$initArray['remove_linebreaks']=false;
									$initArray['remove_redundant_brs'] = false;
									$initArray['wpautop']=false;
									return $initArray;
								}
								add_filter('tiny_mce_before_init', 'hugeit_contact_wptiny' );
								wp_editor(html_entity_decode($param_values['form_adminstrator_message']), "hugeit_contact_adminmessage");;
								?>
								<div class="clear"></div>
							</div>
						</div>

						<div class="hugeit-contact-general-options-block">
							<h3><?php _e("Email To User", 'hugeit_contact');?></h3>
							<div>
								<label for="form_send_to_email_user">
                                    <?php _e("Send Email To User", 'hugeit_contact');?>
                                </label>
								<input type="hidden" value="off" name="params[form_send_to_email_user]" />
								<input type="checkbox" id="form_send_to_email_user"  <?php if($param_values['form_send_to_email_user']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_send_to_email_user]" value="on" />
							</div>
							<div>
								<label for="form_user_message_subject">
                                    <?php _e("Message Subject", 'hugeit_contact');?>
                                </label>
								<input name="params[form_user_message_subject]" type="text" class="" id="form_user_message_subject" value="<?php echo esc_html($param_values['form_user_message_subject']); ?>" size="10" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="If you leave this field empty, the name of the submitted form will be used as the subject of the email.">?</dfn>
							</div>
							<div class="autoheight">
								<label for="form_user_message">
                                    <?php _e("Message", 'hugeit_contact');?>
                                </label>
								<?php wp_editor(html_entity_decode(stripslashes($param_values['form_user_message'])), "hugeit_contact_usermessage"); ?>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
<?php
}
