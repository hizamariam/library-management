<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'books' => User::latest()->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'usertype' => 'User'
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User saved!',
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $fields = $this->validate($request, [
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'required|string'
        ]);

        $user = $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'usertype' => 'User'
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User removed!',
        ]);
    }

    public function getMyFavoriteBooks()
    {
        $user = User::find(auth()->id());
        return response()->json([
            'success' => true,
            'favoriteBooks' => $user->books()->paginate(20)
        ]);
    }
    public function storeFavoriteBook(Book $book)
    {
        $user = User::find(auth()->id());
        $user->books()->syncWithoutDetaching($book->id);
        return response()->json([
            'success' => true,
            'favoriteBooks' => $user->books()->paginate(20)
        ]);
    }

    public function userAddComments(Request $request, Book $book)
    {
        $request->validate(['description' => 'required|string']);
        $user = User::find(auth()->id());
        $book->comments()->create([
            'user_id' => $user->id,
            'description' => $request->description
        ]);
        return response()->json([
            'success' => true,
            'bookComments' => $book->load('comments')
        ]);
    }
}
