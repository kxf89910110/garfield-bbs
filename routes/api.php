<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'change-locale']
], function($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function($api) {
        // SMS verification code
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // User registration
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // Picture verification code
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        // Worth mentioning
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.socials.authorizations.store');
        // Sign in
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // Apple program sign in
        $api->post('weapp/authorizations', 'AuthorizationsController@weappStore')
            ->name('api.weapp.authorizations.store');
        // Apple program sign up
        $api->post('weapp/users', 'UsersController@weappStore')
            ->name('api.weapp.users.store');
        // Refresh token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // Delete token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
        // User details
         $api->get('users/{user}', 'UsersController@show')
             ->name('api.users.show');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        // Visitors can access the interface
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');
        // Topic reply list
        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api.topics.replies.index');
        // A user's reply list
        $api->get('users/{user}/replies', 'RepliesController@userIndex')
            ->name('api.users.replies.index');
        // Resource recommendation
        $api->get('links', 'LinksController@index')
            ->name('api.links.index');
        // Active user
        $api->get('actived/users', 'UsersController@activedIndex')
            ->name('api.actived.users.index');


        // Interface that requires token verification
        $api->group(['middleware' => 'api.auth'], function($api) {
            // Current login user information
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // Edit login user information
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            $api->put('user', 'UsersController@update')
                ->name('api.user.update');
            // Image resource
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            // Post topic
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');
            // Post reply
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');
            // Delete reply
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');
            // Notification list
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            // Notification statistics
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            // Mark message notification as read
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            // User permission list
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });
});
