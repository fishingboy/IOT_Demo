<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Exception;


/*
 *---------------------------------------------------------------
 * OVERRIDE FUNCTIONS
 *---------------------------------------------------------------
 *
 * This will "override" later functions meant to be defined
 * in core\Common.php, so they throw errors instead of output strings
 */
function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
{
	throw new Exception($message, $status_code);
}

function show_404($page = '', $log_error = TRUE)
{
	throw new Exception($page, 404);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */

require_once dirname(__FILE__) . '/../../index.php';
