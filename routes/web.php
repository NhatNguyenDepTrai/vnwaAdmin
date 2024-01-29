<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CategoryProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VinawebappController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryBlogController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProcessController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/generate-content', [ChatGPTController::class, 'AskToChatGpt']);
    Route::post('/ckediter-uploads-file', [FileController::class, 'ckediterUploadsImage']);
    Route::post('/change-status', [VinawebappController::class, 'changeStatus']);
    Route::post('/change-highlight', [VinawebappController::class, 'changeHighlight']);
    Route::post('/delete-items', [VinawebappController::class, 'deleteItems']);
    Route::post('/restore-items', [VinawebappController::class, 'restoreItems']);
    Route::post('/change-ord', [VinawebappController::class, 'changeORD']);
    Route::post('/get-data-district/{id}', [VinawebappController::class, 'getDataDistrict']);
    Route::post('/get-data-ward/{id}', [VinawebappController::class, 'getDataWard']);
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    // start Company
    Route::prefix('company')->group(function () {
        Route::get('', [CompanyController::class, 'showCompany'])->name('Company');
        Route::post('', [CompanyController::class, 'UpdateCompany']);
    });
    // end Company

    // start Category Project
    Route::prefix('category-project')->group(function () {
        Route::get('', [CategoryProjectController::class, 'showIndex'])->name('CategoryProject');
        Route::post('load-data-table', [CategoryProjectController::class, 'loadDataTable']);

        Route::get('/trash', [CategoryProjectController::class, 'showTrash'])->name('CategoryProjectTrash');
        Route::get('/create', function () {
            return Inertia::render('CategoryProject/Create');
        })->name('CategoryProjectCreate');
        Route::post('/create', [CategoryProjectController::class, 'create']);

        Route::get('/edit/{id}', [CategoryProjectController::class, 'showEdit'])->name('CategoryProjectEdit');
        Route::post('/edit/{id}', [CategoryProjectController::class, 'updateCategoryProject']);
    });
    // end Category Project
    // start  Project
    Route::prefix('project')->group(function () {
        Route::get('', [ProjectController::class, 'showIndex'])->name('Project');
        Route::post('load-all-data-category-project', [ProjectController::class, 'loadAllDataCategoryProject']);
        Route::post('load-data-table', [ProjectController::class, 'loadDataTable']);
        Route::get('/trash', [ProjectController::class, 'showTrash'])->name('Project.trash');
        Route::get('create', [ProjectController::class, 'showCreate'])->name('Project.create');

        Route::post('/create', [ProjectController::class, 'create']);

        Route::get('/edit/{id}', [ProjectController::class, 'showEdit'])->name('Project.edit');
        Route::post('/edit/{id}', [ProjectController::class, 'UpdateProject']);
    });
    // end  Project

    Route::prefix('brand')->group(function () {
        Route::get('', [BrandController::class, 'showIndex'])->name('Brand');
        Route::post('load-data-table', [BrandController::class, 'loadDataTable']);
        Route::get('/trash', [BrandController::class, 'showTrash'])->name('Brand.trash');
        Route::get('/create', function () {
            return Inertia::render('Brand/Create');
        })->name('Brand.create');

        Route::post('/create', [BrandController::class, 'create']);

        Route::get('/edit/{id}', [BrandController::class, 'showEdit'])->name('Brand.edit');
        Route::post('/edit/{id}', [BrandController::class, 'update']);
    });

    // start  category blogs
    Route::prefix('category-blog')->group(function () {
        Route::get('', [CategoryBlogController::class, 'showIndex'])->name('CategoryBlog');
        Route::post('load-data-table', [CategoryBlogController::class, 'loadDataTable']);

        Route::get('/trash', [CategoryBlogController::class, 'showTrash'])->name('CategoryBlogTrash');
        Route::get('/create', function () {
            return Inertia::render('CategoryBlog/Create');
        })->name('CategoryBlogCreate');
        Route::post('/create', [CategoryBlogController::class, 'create']);

        Route::get('/edit/{id}', [CategoryBlogController::class, 'showEdit'])->name('CategoryBlogEdit');
        Route::post('/edit/{id}', [CategoryBlogController::class, 'update']);
    });
    // end category blogs
    // start blog tags
    Route::prefix('tag-blog')->group(function () {
        Route::get('', [BlogTagController::class, 'showIndex'])->name('BlogTag');
        Route::post('load-data-table', [BlogTagController::class, 'loadDataTable']);
        Route::get('/create', function () {
            return Inertia::render('BlogTag/Create');
        })->name('BlogTagCreate');
        Route::post('/create', [BlogTagController::class, 'create']);

        Route::get('/edit/{id}', [BlogTagController::class, 'showEdit'])->name('BlogTagEdit');
        Route::post('/edit/{id}', [BlogTagController::class, 'update']);
    });
    // end blog tags

    // start  Blogs
    Route::prefix('blog')->group(function () {
        Route::get('', [BlogController::class, 'showIndex'])->name('Blog');
        Route::post('load-all-data-category-blog', [BlogController::class, 'loadDataTable']);
        Route::post('load-data-table', [BlogController::class, 'loadDataTable']);
        Route::get('/trash', [BlogController::class, 'showTrash'])->name('Blog.trash');
        Route::get('create', [BlogController::class, 'showCreate'])->name('Blog.create');

        Route::post('/create', [BlogController::class, 'create']);

        Route::get('/edit/{id}', [BlogController::class, 'showEdit'])->name('Blog.edit');
        Route::post('/edit/{id}', [BlogController::class, 'update']);
    });
    // end  Blogs

    // start  Process
    Route::prefix('process')->group(function () {
        Route::get('', [ProcessController::class, 'showIndex'])->name('Process');
        Route::post('load-data-table', [ProcessController::class, 'loadDataTable']);
        Route::get('/create', function () {
            return Inertia::render('Process/Create');
        })->name('Process.create');
        Route::post('/create', [ProcessController::class, 'create']);

        Route::get('/edit/{id}', [ProcessController::class, 'showEdit'])->name('Process.edit');
        Route::post('/edit/{id}', [ProcessController::class, 'update']);
    });
    // end  Process
});
