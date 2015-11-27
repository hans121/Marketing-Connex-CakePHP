<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error;
use Cake\Utility\Debugger;
use Cake\Validation\Validation;

if (!Configure::read('debug')):
	//throw new Error\NotFoundException();
endif;
?>
<div style="color:black;">
<?php
echo "<h1 style='color:black;'>TESTING EMAIL VALIDATOR</h1><hr><hr>";

// build API request
$APIUrl = 'http://bulk.email-validator.net/api/verify';
$Params = array('EmailAddress' => 'domhuxley@yahwwoo.co.uk
				domhuxley@yahoo.co.uk
				spam@spam.com'
				,
                'APIKey' => 'ev-bb61957a33cc3a04b18ba5853996007b',
                'NotifyEmail' => 'dom@huxleydigital.co.uk',
                'ValidationMode' => 'express'
                );
$Request = @http_build_query($Params);
$ctxData = array(
     'method' => "POST",
     'header' => "Connection: close\r\n".
     "Content-Length: ".strlen($Request)."\r\n",
     'content'=> $Request);
$ctx = @stream_context_create(array('http' => $ctxData));

// send API request
$result = json_decode(@file_get_contents(
    $APIUrl, false, $ctx));

print_r($result );

// check API result
if ($result && $result->{'status'} > 0) {
    switch ($result->{'status'}) {
        // valid addresses have a {200, 207, 215} result code
        // result codes 114 and 118 need a retry
        case 200:
        case 207:
        case 215:
                echo "Address is valid.<br/>";
                break;
        case 114:
                // greylisting, wait 5min and retry
                break;
        case 118:
                // api rate limit, wait 5min and retry
                break;
        default:
                echo "Address is invalid.<br/>";
                echo $result->{'info'}."<br/>";
                echo $result->{'details'}."<br/><br/>";
                break;
    }
} else {
    echo $result->{'info'}."<br/><br/>";
}
	
	
?>	

</div>