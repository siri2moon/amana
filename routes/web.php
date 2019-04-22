<?php


Route::prefix('api')->group(function () {
    Route::get('latest-version', 'ApiController@getLatestVersion')->name('amana.get.latest-version');
    Route::get('downloads', 'ApiController@getDownloads')->name('amana.get.app.downloads');
    Route::post('upload', 'ApiController@postUploadApp')->name('amana.post.app.upload');
});

// Catch-all Route...
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('amana.index');
