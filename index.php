<?php
/**
 * SocialPlus - A light and agile social network
 *
 * @author      Paras Dahal <shree5paras@gmail.com>
 * @copyright   2015 Paras Dahal
 * @link        http://www.github.com/parasdahal/socialplus
 * @license     MIT licence
 * @version     1.0
 * @package     socialplus
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace socialplus;

require 'vendor/autoload.php';

$app = new \Slim\Slim();

$view=$app->view();

$view->setTemplatesDirectory('./views');
/**
 * Home route
 */
$app->get('/', function () use ($app) {
    
    $app->render('login.html');

});
$app->get('/login', function () use ($app) {
    
    $app->render('login.html');

});
$app->get('/signup', function () use ($app) {
    
    $app->render('signup.html');

});
$app->get('/home', function () use ($app) {
    
    $app->render('news_feed.html');

});

$app->get('/:id', function ($id) use ($app) {
    
    $app->render('user.php');

});

$app->get('/profile', function() use ($app) {

	//$app->render('user.php?username='.$args['username']);
	$app->render('profile.html');
});



$app->run();

?>