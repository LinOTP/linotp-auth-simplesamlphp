<?php

/**
 * This page asks the user to authenticate using an OTP from a device
 * registered with your LinOTP server.
 * 
 * Largely based on code by Jaime Pérez Crespo,
 * UNINETT AS <jaime.perez@uninett.no>.
 *
 * @author Greg Harvey, Code Enigma <greg.harvey@codeenigma.com>.
 * @package SimpleSAMLphp\Module\linotp2
 */

if (!array_key_exists('StateId', $_REQUEST)) {
    throw new SimpleSAML_Error_BadRequest('Missing AuthState parameter.');
}
$authStateId = $_REQUEST['StateId'];
$state = SimpleSAML_Auth_State::loadState($authStateId, 'linotp2:otp:init');

$error = false;
if (array_key_exists('otp', $_POST)) { // we were given an OTP
    try {
    	if (sspmod_linotp2_Auth_Process_OTP::authenticate($state, $_POST['otp'])) {
            SimpleSAML_Auth_State::saveState($state, 'linotp2:otp:init');
            SimpleSAML_Auth_ProcessingChain::resumeProcessing($state);
        } else {
            $error = '{linotp2:errors:invalid_otp}';
        }
    } catch (InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}

$cfg = SimpleSAML_Configuration::getInstance();
$tpl = new SimpleSAML_XHTML_Template($cfg, 'linotp2:otp.php');
$tpl->data['params'] = array('StateId' => $authStateId);
$tpl->data['error'] = ($error) ? $tpl->t($error) : false;
$tpl->show();
