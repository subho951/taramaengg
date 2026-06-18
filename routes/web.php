<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });
/* Front Panel */
    Route::get('/', 'App\Http\Controllers\FrontController@home')->name('home');
    Route::get('/blogs', 'App\Http\Controllers\FrontController@blogs')->name('blogs');
    Route::get('/blogs/{slug}', 'App\Http\Controllers\FrontController@blogDetails')->name('blog.details');
    Route::get('/who-we-are', 'App\Http\Controllers\FrontController@whoWeAre')->name('who-we-are');
    Route::redirect('/about-us', '/who-we-are');
    Route::get('/products', 'App\Http\Controllers\FrontController@products')->name('products');
    Route::get('/products/category/{slug}', 'App\Http\Controllers\FrontController@products')->name('products.category');
    Route::match(['get', 'post'], '/career', 'App\Http\Controllers\FrontController@career')->name('career');
    Route::get('/clients', 'App\Http\Controllers\FrontController@clients')->name('clients');
    Route::match(['get', 'post'], '/contact-us', 'App\Http\Controllers\FrontController@contactUs')->name('contact-us');
    Route::get('/page/{slug}', 'App\Http\Controllers\FrontController@page')->name('page');
/* Front Panel */
/* Admin Panel */
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::match(['get', 'post'], '/', 'UserController@login');
    Route::match(['get', 'post'], 'forgot-password', 'UserController@forgotPassword');
    Route::match(['get', 'post'], 'validateOtp/{id}', 'UserController@validateOtp');
    Route::match(['get', 'post'], 'resendOtp/{id}', 'UserController@resendOtp');
    Route::match(['get', 'post'], 'changePassword/{id}', 'UserController@changePassword');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'UserController@dashboard');
        Route::get('logout', 'UserController@logout');
        Route::get('settings', 'UserController@settings');
        Route::post('profile-settings', 'UserController@profile_settings');
        Route::post('general-settings', 'UserController@general_settings');
        Route::post('change-password', 'UserController@change_password');
        Route::post('email-settings', 'UserController@email_settings');
        Route::post('email-template', 'UserController@email_template');
        Route::post('sms-settings', 'UserController@sms_settings');
        Route::post('footer-settings', 'UserController@footer_settings');
        Route::post('seo-settings', 'UserController@seo_settings');
        Route::post('payment-settings', 'UserController@payment_settings');
        Route::post('signature-settings', 'UserController@signature_settings');
        Route::get('email-logs', 'UserController@emailLogs');
        Route::match(['get', 'post'], 'email-logs/details/{email}', 'UserController@emailLogsDetails');
        Route::get('login-logs', 'UserController@loginLogs');

        Route::get('banner/list', 'BannerController@list');
        Route::match(['get', 'post'], 'banner/add', 'BannerController@add');
        Route::match(['get', 'post'], 'banner/edit/{id}', 'BannerController@edit');
        Route::get('banner/delete/{id}', 'BannerController@delete');
        Route::get('banner/change-status/{id}', 'BannerController@change_status');

        Route::match(['get', 'post'], 'about-us', 'AboutUsController@index');

        Route::get('why-us-point/list', 'WhyUsPointController@list');
        Route::match(['get', 'post'], 'why-us-point/add', 'WhyUsPointController@add');
        Route::match(['get', 'post'], 'why-us-point/edit/{id}', 'WhyUsPointController@edit');
        Route::get('why-us-point/delete/{id}', 'WhyUsPointController@delete');
        Route::get('why-us-point/change-status/{id}', 'WhyUsPointController@changeStatus');

        Route::get('homepage-counter/list', 'HomepageCounterController@list');
        Route::match(['get', 'post'], 'homepage-counter/add', 'HomepageCounterController@add');
        Route::match(['get', 'post'], 'homepage-counter/edit/{id}', 'HomepageCounterController@edit');
        Route::get('homepage-counter/delete/{id}', 'HomepageCounterController@delete');
        Route::get('homepage-counter/change-status/{id}', 'HomepageCounterController@changeStatus');

        Route::get('client-logo/list', 'ClientLogoController@list');
        Route::match(['get', 'post'], 'client-logo/add', 'ClientLogoController@add');
        Route::match(['get', 'post'], 'client-logo/edit/{id}', 'ClientLogoController@edit');
        Route::get('client-logo/delete/{id}', 'ClientLogoController@delete');
        Route::get('client-logo/change-status/{id}', 'ClientLogoController@changeStatus');

        Route::get('product-category/list', 'ProductCategoryController@list');
        Route::match(['get', 'post'], 'product-category/add', 'ProductCategoryController@add');
        Route::match(['get', 'post'], 'product-category/edit/{id}', 'ProductCategoryController@edit');
        Route::get('product-category/delete/{id}', 'ProductCategoryController@delete');
        Route::get('product-category/change-status/{id}', 'ProductCategoryController@changeStatus');

        Route::get('product/list', 'ProductController@list');
        Route::match(['get', 'post'], 'product/add', 'ProductController@add');
        Route::match(['get', 'post'], 'product/edit/{id}', 'ProductController@edit');
        Route::get('product/delete/{id}', 'ProductController@delete');
        Route::get('product/change-status/{id}', 'ProductController@changeStatus');

        Route::get('career-application/list', 'CareerApplicationController@list');
        Route::get('career-application/details/{id}', 'CareerApplicationController@details');
        Route::post('career-application/status/{id}', 'CareerApplicationController@updateStatus');
        Route::get('career-application/delete/{id}', 'CareerApplicationController@delete');

        Route::get('blog-category/list', 'BlogCategoryController@list');
        Route::match(['get', 'post'], 'blog-category/add', 'BlogCategoryController@add');
        Route::match(['get', 'post'], 'blog-category/edit/{id}', 'BlogCategoryController@edit');
        Route::get('blog-category/delete/{id}', 'BlogCategoryController@delete');
        Route::get('blog-category/change-status/{id}', 'BlogCategoryController@changeStatus');

        Route::get('blog/list', 'BlogController@list');
        Route::match(['get', 'post'], 'blog/add', 'BlogController@add');
        Route::match(['get', 'post'], 'blog/edit/{id}', 'BlogController@edit');
        Route::get('blog/delete/{id}', 'BlogController@delete');
        Route::get('blog/change-status/{id}', 'BlogController@changeStatus');

        Route::get('testimonial/list', 'TestimonialController@list');
        Route::match(['get', 'post'], 'testimonial/add', 'TestimonialController@add');
        Route::match(['get', 'post'], 'testimonial/edit/{id}', 'TestimonialController@edit');
        Route::get('testimonial/delete/{id}', 'TestimonialController@delete');
        Route::get('testimonial/change-status/{id}', 'TestimonialController@change_status');

        Route::get('gallery-category/list', 'GalleryCategoryController@list');
        Route::match(['get', 'post'], 'gallery-category/add', 'GalleryCategoryController@add');
        Route::match(['get', 'post'], 'gallery-category/edit/{id}', 'GalleryCategoryController@edit');
        Route::get('gallery-category/delete/{id}', 'GalleryCategoryController@delete');
        Route::get('gallery-category/change-status/{id}', 'GalleryCategoryController@change_status');

        Route::get('gallery/list', 'GalleryController@list');
        Route::match(['get', 'post'], 'gallery/add', 'GalleryController@add');
        Route::match(['get', 'post'], 'gallery/edit/{id}', 'GalleryController@edit');
        Route::get('gallery/delete/{id}', 'GalleryController@delete');
        Route::get('gallery/change-status/{id}', 'GalleryController@change_status');

        Route::get('faq-category/list', 'FaqCategoryController@list');
        Route::match(['get', 'post'], 'faq-category/add', 'FaqCategoryController@add');
        Route::match(['get', 'post'], 'faq-category/edit/{id}', 'FaqCategoryController@edit');
        Route::get('faq-category/delete/{id}', 'FaqCategoryController@delete');
        Route::get('faq-category/change-status/{id}', 'FaqCategoryController@change_status');

        Route::get('faq/list', 'FaqController@list');
        Route::match(['get', 'post'], 'faq/add', 'FaqController@add');
        Route::match(['get', 'post'], 'faq/edit/{id}', 'FaqController@edit');
        Route::get('faq/delete/{id}', 'FaqController@delete');
        Route::get('faq/change-status/{id}', 'FaqController@change_status');
        Route::get('faq/change-home-page-status/{id}', 'FaqController@change_home_page_status');
        Route::post('faq/sorting-content', 'FaqController@sortingContent');

        Route::get('page/list', 'PageController@list');
        Route::match(['get', 'post'], 'page/add', 'PageController@add');
        Route::match(['get', 'post'], 'page/edit/{id}', 'PageController@edit');
        Route::get('page/delete/{id}', 'PageController@delete');
        Route::get('page/change-status/{id}', 'PageController@change_status');

        Route::get('enquiry/list', 'EnquiryController@list');
        Route::get('enquiry/view-details/{id}', 'EnquiryController@details');
        Route::get('enquiry/delete/{id}', 'EnquiryController@delete');

        Route::get('notice/list', 'NoticeController@list');
        Route::match(['get', 'post'], 'notice/add', 'NoticeController@add');
        Route::match(['get', 'post'], 'notice/edit/{id}', 'NoticeController@edit');
        Route::get('notice/delete/{id}', 'NoticeController@delete');
        Route::get('notice/change-status/{id}', 'NoticeController@change_status');

        Route::get('country/list', 'CountryController@list');
        Route::match(['get', 'post'], 'country/add', 'CountryController@add');
        Route::match(['get', 'post'], 'country/edit/{id}', 'CountryController@edit');
        Route::get('country/delete/{id}', 'CountryController@delete');
        Route::get('country/change-status/{id}', 'CountryController@change_status');

        Route::get('module/list', 'ModuleController@list');
        Route::match(['get', 'post'], 'module/add', 'ModuleController@add');
        Route::match(['get', 'post'], 'module/edit/{id}', 'ModuleController@edit');
        Route::get('module/delete/{id}', 'ModuleController@delete');
        Route::get('module/change-status/{id}', 'ModuleController@change_status');

        Route::get('sub-user/list', 'SubUserController@list');
        Route::match(['get', 'post'], 'sub-user/add', 'SubUserController@add');
        Route::match(['get', 'post'], 'sub-user/edit/{id}', 'SubUserController@edit');
        Route::get('sub-user/delete/{id}', 'SubUserController@delete');
        Route::get('sub-user/change-status/{id}', 'SubUserController@change_status');

        Route::get('subscriber/list', 'SubscriberController@list');
        Route::match(['get', 'post'], 'subscriber/add', 'SubscriberController@add');
        Route::match(['get', 'post'], 'subscriber/edit/{id}', 'SubscriberController@edit');
        Route::get('subscriber/delete/{id}', 'SubscriberController@delete');
        Route::get('subscriber/change-status/{id}', 'SubscriberController@change_status');

        Route::get('newsletter/list', 'NewsletterController@list');
        Route::match(['get', 'post'], 'newsletter/add', 'NewsletterController@add');
        Route::match(['get', 'post'], 'newsletter/edit/{id}', 'NewsletterController@edit');
        Route::get('newsletter/delete/{id}', 'NewsletterController@delete');
        Route::get('newsletter/change-status/{id}', 'NewsletterController@change_status');
        Route::get('newsletter/send/{id}', 'NewsletterController@send');
        Route::post('newsletter/get-user', 'NewsletterController@getUser');
    });
});
/* Admin Panel */
/* Api */
    Route::prefix('api')->namespace('App\Http\Controllers')->group(function(){
        // Other Version 2 routes
        /* before login */
            Route::match(['get'], '/get-app-setting', 'ApiController@getAppSetting');
            Route::match(['get'], '/get-source', 'ApiController@getSource');
            Route::match(['get'], '/get-center', 'ApiController@getCenter');
            Route::match(['get'], '/get-document-type', 'ApiController@getDocumentType');
            Route::match(['get'], '/get-level', 'ApiController@getLevel');
            Route::match(['get'], '/get-country', 'ApiController@getCountry');
            Route::match(['post'], '/get-state', 'ApiController@getState');
            Route::match(['post'], '/get-district', 'ApiController@getDistrict');
            Route::match(['post'], '/get-static-pages', 'ApiController@getStaticPages');
            Route::match(['get'], '/get-notice', 'ApiController@getNotice');
            Route::match(['get'], '/get-all-masters', 'ApiController@getAllMasters');

            Route::match(['post'], '/signin', 'ApiController@signin');
            Route::match(['post'], '/forgot-password', 'ApiController@forgotPassword');
            Route::match(['post'], '/validate-otp', 'ApiController@validateOtp');
            Route::match(['post'], '/resend-otp', 'ApiController@resendOtp');
            Route::match(['post'], '/reset-password', 'ApiController@resetPassword');
        /* before login */
        /* after login */
            Route::match(['get'], '/signout', 'ApiController@signout');
            Route::match(['get'], '/dashboard', 'ApiController@dashboard');
            Route::match(['post'], '/change-password', 'ApiController@changePassword');
            Route::match(['get'], '/get-profile', 'ApiController@getProfile');
            Route::match(['get'], '/edit-profile', 'ApiController@editProfile');
            Route::match(['post'], '/update-profile', 'ApiController@updateProfile');
            Route::match(['get'], '/delete-account', 'ApiController@deleteAccount');
            Route::match(['get'], '/student-list', 'ApiController@studentList');
            Route::match(['post'], '/student-detail', 'ApiController@studentDetail');
            Route::match(['post'], '/add-student', 'ApiController@addStudent');
            Route::match(['post'], '/edit-student', 'ApiController@editStudent');
            Route::match(['post'], '/update-student', 'ApiController@updateStudent');
            Route::match(['post'], '/upload-profile-image', 'ApiController@uploadProfileImage');
            Route::match(['get'], '/my-center', 'ApiController@myCenter');
        /* after login */
    });
/* Api */
