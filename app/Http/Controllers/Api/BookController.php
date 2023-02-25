<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success'=>true,
            'books' => Book::latest()->paginate(10)
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
        $book = Book::create(
            $request->validate([
                'title'=>'required|string',
                'description'=>'required|string'
            ])
        );

        if($request->hasFile('book_file')){
            $book->clearMediaCollection('books');
            $book->addMediaFromRequest('book_file')->toMediaCollection('books');
        }
        return response()->json([
            'success'=>true,
            'message'=>'Book saved!',
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->update(
            $request->validate([
                'title'=>'required|string',
                'description'=>'required|string'
            ])
        );

        if($request->hasFile('book_file')){
            $book->clearMediaCollection('books');
            $book->addMediaFromRequest('book_file')->toMediaCollection('books');
        }
        return response()->json([
            'success'=>true,
            'message'=>'Book updated!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Book removed!',
        ]);
    }
}
