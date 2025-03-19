<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Projects\Project\ProjectController;

//DASHBOARD
use App\Http\Controllers\Settings\RoleController;

//BUDGET

use App\Http\Controllers\Settings\UserProfileController;
use App\Http\Controllers\Settings\{MenuController, AccountsController, HierarchyController};
// use App\Http\Controllers\Settings\{MenuController, AccountsController};
use App\Http\Livewire\UpdateComponent;
use App\Livewire\Approved\Approval;
use App\Livewire\Approved\DashApprover;
use App\Livewire\Approved\Pengajuan\ShowSubmit;
use App\Livewire\Approved\Pengajuan\UploadRule;
use App\Livewire\Approved\ShowForm;
use App\Livewire\Availability\AvailabilityTracking;
use App\Livewire\Availability\Performa;
use App\Livewire\AvailabilityTracking\TryChart;
use App\Livewire\Budget\Index as BudgetIndex;
use App\Livewire\Budget\Plan\Plan as BudgetPlan;
use App\Livewire\Budget\Track\Track as BudgetTrack;
use App\Livewire\Dashboard\Dashboard as Dashboard;
use App\Livewire\Master\BudgetCategory\ShowBudgetCategory;
use App\Livewire\Master\BudgetCategory\ShowBudgetSubCategory;
use App\Livewire\Master\Helper;
//PROJECTS
use App\Livewire\Master\Holiday\ShowHoliday;
use App\Livewire\Master\ProjectStatus\ShowProjectStatus;
use App\Livewire\Master\TaskCategory\ShowTaskCategory;
//TASK
use App\Livewire\Master\TaskFlag\ShowTaskFlag;

//REPORT
use App\Livewire\Master\TaskLabel\ShowTaskLabel;
use App\Livewire\Master\TaskStatus\ShowTaskStatus;
// RELEASE NOTES
use App\Livewire\Master\Uom\Measure;
use App\Livewire\Projects\Budget\Category as ProjectsBudgetCategory;
use App\Livewire\Projects\Budget\Plan\ShowPlan as PlanShowPlan;
use App\Livewire\Projects\Budget\ShowBudget;

use App\Livewire\Projects\Budget\SubCategory as ProjectsBudgetSubCategory;
use App\Livewire\Projects\Budget\Track\DetailNota;
use App\Livewire\Projects\Budget\Track\ShowTrack;

use App\Livewire\Projects\Calendar\ShowCalendar;
use App\Livewire\Projects\GanttChart\ShowGanttChart;
use App\Livewire\Projects\Projects\ArchivedProject;
use App\Livewire\Projects\Projects\ProjectDetail as ProjectDetail;
use App\Livewire\Projects\Projects\ShowProject as ShowProject;
use App\Livewire\Projects\Release\FormReleaseNote;
use App\Livewire\Projects\Release\ReleaseDetail;
use App\Livewire\Projects\Release\ReleaseNotes;
use App\Livewire\Projects\Release\ShowReleaseNote as ShowRelease;
use App\Livewire\Projects\Tasks\ArchivedTask;
use App\Livewire\Projects\Tasks\ShowTask as ShowTask;
use App\Livewire\Report\ShowReport;
use App\Livewire\StartWork;
use App\Livewire\TableTrial;
use App\Livewire\TimeCard\ShowTimeCard;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;





//Active this in dev or prod
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('pm/livewire/update', $handle);
});

Route::get('/', [LoginController::class,'index'])->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/process', [LoginController::class, 'authenticate']);

Route::get('/lupa-password', [ResetPasswordController::class, 'index']);
Route::post('/lupa-password/process', [ResetPasswordController::class, 'resetPasswordProcess']);
Route::get('/ubah-password', [ResetPasswordController::class, 'ubahPassword']);
Route::post('/ubah-password/process', [ResetPasswordController::class, 'ubahPasswordProcess']);

Route::get('/trial', TableTrial::class)->name('table-trial');

Route::middleware(['auth'])->group(function () {
    Route::get('/', StartWork::class)->name('start');
    Route::get('/logout', [LogoutController::class, 'logout']);

    Route::prefix('projects')->name('projects.')->group(function () {

        // CRUD PROJECT
        Route::get('/', ShowProject::class)->name('show.project');
        Route::get('/archived', ArchivedProject::class)->name('project.archived');
    
        Route::prefix('{projectId}')->group(function () {
            Route::get('/', Dashboard::class)->name('dashboard.task');
    
            //CRUD TASKS
            Route::get('/tasks', ShowTask::class)->name('tasks.show');
            Route::get('/tasks/archived', ArchivedTask::class)->name('tasks.archived');
            Route::get('/calendar', ShowCalendar::class)->name('calendar');
            Route::get('/ganttchart', ShowGanttChart::class)->name('ganttchart');
    
            //CRUD RELEASE NOTE
            Route::prefix('release-note')->name('release.')->group(function () {
                //release notes
                Route::get('/', ReleaseNotes::class)->name('show.release');
                Route::get('/{id}', ReleaseDetail::class)->name('detail.release');
            });
        });
    });

    Route::prefix('budget')->name('budget.')->group(function () {
        Route::get('/', ShowBudget::class)->name('show.budget');

            // PLAN
            Route::get('/plan/{title}', PlanShowPlan::class)->name('show.plan');
            // TRACK
            Route::get('/track/{title}', ShowTrack::class)->name('show.track');
            Route::get('/track/{title}/detail-nota/{id}', DetailNota::class)->name('detail.nota');
    });
    
    Route::prefix('time-card')->name('time-card.')->group(function () {
        Route::get('/', ShowTimeCard::class)->name('show');
    });
    
    Route::prefix('availability-tracking')->name('availability-tracking.')->group(function () {
        Route::get('/', AvailabilityTracking::class)->name('show');
        Route::get('/performa/{employeeId}',  Performa::class)->name('show.performa');
        // try chart
        // Route::get('/performa/{employeeId}/trychart', TryChart::class)->name('show.chart');
    });
    
    Route::prefix('report')->name('report.')->group(function () {
        //route report
        Route::get('/', ShowReport::class)->name('show.report');
    });

    // APPROVAL
    Route::prefix('approval')->name('approval.')->group(function () {
        // route dashboard pemohon
        Route::get('dashboard-request', Approval::class)->name('dashboard-request');
        // route pengajuan approval
        Route::get('form-approval', ShowSubmit::class)->name('form-approval');
        // route upload ketentuan for HR
        Route::get('upload-rule', UploadRule::class)->name('upload-rule'); 
        // route dashboard approver
        Route::get('dashboard-approver', DashApprover::class)->name('dashboard-approver'); 
    });
    // END APPROVAL
    
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/project-status', ShowProjectStatus::class)->name('project-status');
        Route::get('/task-status', ShowTaskStatus::class)->name('task-status');
        Route::get('/task-flag', ShowTaskFlag::class)->name('task-flag');
        Route::get('/task-label', ShowTaskLabel::class)->name('task-label');
        Route::get('/task-category', ShowTaskCategory::class)->name('task-category');
        Route::get('/budget-category', ShowBudgetCategory::class)->name('budget-category');
        Route::get('/budget-subcategory', ShowBudgetSubCategory::class)->name('budget-subcategory');
        Route::get('/holidays', ShowHoliday::class)->name('holidays');
        Route::get('/uom', Measure::class)->name('uom');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/menu', [MenuController::class, 'index'])->name('menu');
        Route::get('/menu/add', [MenuController::class, 'add'])->name('menu.add');
        Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::get('/menu/access_control/{id}', [MenuController::class, 'accessControl'])->name('menu.access');
        Route::post('/menu/add_process', [MenuController::class, 'addProcess'])->name('menu.post');
        Route::post('/menu/edit_process', [MenuController::class, 'editProcess'])->name('menu.edit.post');
        Route::get('/menu/delete_process/{id}', [MenuController::class, 'deleteProcess'])->name('menu.delete');
        // Role
        Route::get('/role', [RoleController::class, 'index'])->name('role');
        Route::get('/role/add', [RoleController::class, 'add'])->name('role.add');
        Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/role/edit_process', [RoleController::class, 'editProcess'])->name('role.update');
        Route::post('/role/add_process', [RoleController::class, 'addProcess'])->name('role.post');
        Route::get('/role/delete_process/{id}', [RoleController::class, 'deleteProcess'])->name('role.delete');
        Route::get('/role/access_right/{id}', [RoleController::class, 'access_right'])->name('role.access_right');
        // Account
        Route::get('/accounts', [AccountsController::class, 'index'])->name('account.index');
        Route::get('/accounts/add', [AccountsController::class, 'add'])->name('account.add');
        Route::post('/accounts/add_process', [AccountsController::class, 'addProcess'])->name('account.addProcess');
        Route::get('/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('account.edit');
        Route::post('/accounts/edit_process', [AccountsController::class, 'editProcess'])->name('account.editProcess');
        Route::get('/accounts/edit_password/{id}', [AccountsController::class, 'editPassword'])->name('account.editPassword');
        Route::post('/accounts/edit_password_process', [AccountsController::class, 'editPasswordProcess'])->name('account.editPasswordProcess');
        Route::get('/accounts/delete_process/{id}', [AccountsController::class, 'deleteProcess'])->name('account.deleteProcess');
        Route::get('/accounts/search', [AccountsController::class, 'search'])->name('account.search');
        // Hierarchy
        Route::get('/hierarcy', [HierarchyController::class, 'index'])->name('hierarchy.index');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function(){
    Route::controller('HierarchyController')->group(function(){
        Route::get('/hierarchy', 'index');
    });
});


