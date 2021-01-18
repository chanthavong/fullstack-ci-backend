<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['jwt_key'] = 'ingDLMRuGe9UKHRNjs7cYckS2yul4lc3dDFGDdssd';

/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = time()* 60 * 24 * 7 ; // 1 week

/* End of file jwt.php */
/* Location: ./application/config/jwt.php */