<?php

use App\Http\Controllers\ChatDestroyController;
use App\Http\Controllers\ChatGptDestroyController;
use App\Http\Controllers\ChatGptIndexController;
use App\Http\Controllers\ChatGptStoreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;





Route::get("/admin/users", [AdminController::class, "index"])->name('admin.users');


Route::patch("/admin/users/{user}/restrict", [
    AdminController::class,
    "restrictUser",
])->name("admin.users.restrict");

Route::patch("/admin/users/{user}/allow", [
    AdminController::class,
    "allowUser",
])->name("admin.users.allow");


Route::middleware(["admin"])->group(function () {
    Route::get("/admin/dashboard", [AdminController::class, "index"]);
    Route::get("/admin/users", [AdminController::class, "showUsers"]);
    Route::delete("/admin/users/{user}", [
        AdminController::class,
        "deleteUser",
    ]);
    // Add other admin-related routes...
});

Route::get("/", function () {
    return Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ]);
});

Route::get("/dashboard", function () {
    return Inertia::render("Dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::middleware("auth", "blockcheck")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );

    Route::get("/chat/{id?}", ChatGptIndexController::class)->name("chat.show");
    Route::post("/chat/{id?}", ChatGptStoreController::class)->name(
        "chat.store"
    );
    Route::delete("/chat/{chat}", ChatGptDestroyController::class)->name(
        "chat.destroy"
    );

});

require __DIR__ . "/auth.php";
