<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'UserController@me');

    Route::post('/setCart', 'UserController@setCart');
    Route::get('/getCart',  'UserController@getCart');

    Route::patch('settings/profile',  'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::resource('/settings/user-delivery-addresses', "UserDeliveryAddressController");

    //Route::resource('/orders', "OrderController");

    // 1C
    Route::group(['middleware' => 'App\Http\Middleware\Middleware1c'], function() {
        Route::prefix("update")->group(function() {
            Route::post('stores',                   "StoreController".                  "@update1c");
            Route::post('categories',               "CategoryController".               "@update1c");
            Route::post('category-characteristics', "CategoryCharacteristicController". "@update1c");
            Route::post('characteristics',          "CharacteristicController".         "@update1c");
            Route::post('characteristic-types',     "CharacteristicTypeController".     "@update1c");
            Route::post('products',                 "ProductController".                "@update1c");
            Route::post('prices',                   "PriceController".                  "@update1c");
            Route::post('store-balances',           "StoreBalanceController".           "@update1c");
            Route::post('product-characteristics',  "ProductCharacteristicController".  "@update1c");
            Route::post('images',                   "Image1cController".                "@update1c");
            Route::post('stocks',                   "StockController".                  "@update1c");
            Route::post('slider',                   "SliderSlideController".            "@update1c");
            Route::post('vacancies',                "VacancyController".                "@update1c");
            Route::post('delivery-methods',         "DeliveryMethodController".         "@update1c");

            Route::post('getUsers',                 "UserController".                   "@getBy1c");
            Route::post('getOrders',                "OrderController".                  "@getBy1c");
            Route::post('getProducts',              "ProductController".                "@getBy1c");
            Route::post('getCategories',            "CategoryController".               "@getBy1c");
            Route::post('getStocks',                "StockController".                  "@getBy1c");
            Route::post('getPrices',                "PriceController".                  "@getBy1c");
            Route::post('getStoreBalances',         "StoreBalanceController".           "@getBy1c");

            Route::post('setSynchronizedUsers',     "UserController".                   "@setSynchronizedBy1c");
            Route::post('setSynchronizedOrders',    "OrderController".                  "@setSynchronizedBy1c");

            Route::post('setUserModerated',         "UserController".                   "@setModeratedBy1c");
        });
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login',    'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::resource('stores',       "StoreController");
Route::resource('categories',   "CategoryController");
Route::resource('products',     "ProductController");
Route::resource('articles',     "ArticleController");

Route::get('/getMainPageProducts',    "ProductController@getMainPageProducts");
Route::post('/products/getListByIds', "ProductController@getListByIds");

Route::get('/search', "SearchController@query");
Route::get('/vacancies', "VacancyController@index");

Route::post('/order', "OrderController@order");
Route::get('slider',                   "SliderSlideController".             "@getSlides");
Route::get('also-by-products',         "ProductController".                 "@alsoBy"   );

Route::get('pay/{order_id}',           "OrderController".                   "@payOnline");
Route::get('order/success',            "OrderController".                   "@checkPaymentStatus");

Route::get('delivery-methods', function () {
    return \App\DeliveryMethod::where("is_active", 1)->get();
});
