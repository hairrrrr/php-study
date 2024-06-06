<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    public function index()
    {
        $notes = Note::onlyTrashed()->with('user')->get();
        // $notes = $notes->with('user')->latest()->paginate(5);
    
        return view('trash.index', [
            'notes' => $notes
            ]
        );   
    }

    public function edit(int $id)
    {
        $note = Note::onlyTrashed()->find($id);
        return view('trash.edit', ["note" => $note]);
    }

    public function update(int $id)
    {
        $note = Note::onlyTrashed()->find($id);
        $note->restore();
        return redirect("/notes/" . $id);
    }

    public function destory(int $id)
    {
        $note = Note::onlyTrashed()->find($id);
        $note->forceDelete();
        return redirect('/trash');
    }

}
