<?php

use Utils\Database\XDb;

//prepare the templates and include all neccessary
require_once('./lib/common.inc.php');

//Preprocessing
if ($error == false) {
    //set here the template to process
    $tplname = 'activation';

    //load language specific variables
    require_once($stylepath . '/' . $tplname . '.inc.php');

    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
    $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';


    tpl_set_var('email', htmlspecialchars($email, ENT_COMPAT, 'UTF-8'));
    tpl_set_var('code', htmlspecialchars($code, ENT_COMPAT, 'UTF-8'));
    tpl_set_var('message_start', '<!--');
    tpl_set_var('message_end', '-->');
    tpl_set_var('message', '');
    tpl_set_var('email_message', '');

    if (isset($_REQUEST['submit'])) {
        $email_not_ok = is_valid_email_address($email) ? false : true;

        if ($email_not_ok == true) {
            tpl_set_var('email_message', $message_email_notok);
        } else {
            $rs = XDb::xSql("SELECT `user_id` `id`, `activation_code` `code`
                        FROM `user` WHERE `email`= ? ", $email);
            if ($r = XDb::xFetchArray($rs)) {
                if (($r['code'] == $code) && ($code != '')) {
                    XDb::xFreeResults($rs);

                    // ok, account aktivieren
                    XDb::xSql("UPDATE `user` SET `is_active_flag`=1, `activation_code`='' WHERE `user_id`= ? ", $r['id']);

                    $tplname = 'activation_confirm';
                } else {
                    tpl_set_var('message_start', '');
                    tpl_set_var('message_end', '');
                    tpl_set_var('message', $message_no_success);
                }
            } else {
                tpl_set_var('message_start', '');
                tpl_set_var('message_end', '');
                tpl_set_var('message', $message_no_success);
            }
            XDb::xFreeResults($rs);
        }
    }
}

//make the template and send it out
tpl_BuildTemplate();
?>
