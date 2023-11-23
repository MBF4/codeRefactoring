<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function index()
    {
        // Load the admin dashboard view
        return view("admin.dashboard");
    }

    public function showUsers()
    {
        // Retrieve all users with the count of their chats
        $users = User::withCount("chats")->get();
        // Load the view and pass the users with chats count
        return view("admin.users", compact("users"));
    }

    public function deleteUser(User $user)
    {
        // Delete the user and redirect back to the users page
        $user->delete();
        return redirect("/admin/users")->with(
            "success",
            "User deleted successfully."
        );
    }
    public function restrictUser(Request $request, User $user)
    {
        $user->update(["block" => 1]);
        // Redirect back with a success message, or handle as needed
        return back()->with("success", "User restricted successfully.");
    }

    public function allowUser(Request $request, User $user)
    {
        $user->update(["block" => 0]);
        // Redirect back with a success message, or handle as needed
        return back()->with("success", "User Allowed successfully.");
    }
}
