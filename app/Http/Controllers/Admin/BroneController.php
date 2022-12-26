<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\book;
use App\Models\BookProizvoditel;

class BroneController extends Controller
{
    public function AllBrone(){
       $books = book::OrderBy('id', 'DESC')->paginate(10);
       return view('AdminView.AllBrone',compact('books'));
    }
    public function OnePageBrone($id){
        $get_book = book::with('book_designer')->where('id', $id)->get();

     $get_brone = BookProizvoditel::with('book_proizvoditel_user', 'book_proizvoditel_user.user_pracient_for_designer')
         ->where('books_id', $id)->get();
        return view('AdminView.OnePageBook', compact('get_brone', 'get_book'));
    }
}
