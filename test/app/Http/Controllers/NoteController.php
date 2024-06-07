<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use App\Utils\GenerateTitle;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{
    public function index()
    {
        //$notes = Note::with('user')->latest()->paginate(5);
        $notes = Note::withoutTrashed()->with('user')->get();

    
        return view('notes.index', [
            'notes' => $notes
            ]
        );
    }

    public function create()
    {
        return view('notes.create');
    }

    public function show(Note $note)
    {
        return view('notes.show', ["note" => $note]);
    }

    public function store()
    {
        request()->validate([
            'title'   =>  ['required', 'min: 3'],
            'content' =>  ['required'],
         ]);
         
         $note = Note::create([
             'user_id' => Auth::user()->id,
             'title'   => request('title'), 
             'content' => request('content'),
         ]);
         

         return redirect("/notes/{$note->id}");
    }


    public function edit(Note $note)
    {
        return view('notes.edit', ["note" => $note]);
    }


    public function update(Note $note)
    {
        request()->validate([
            'title'  => ['required', 'min: 3'],
            'content' => ['required']
         ]);
        
         $note->update([
             'title' => request('title'), 
             'content'=> request('content'),
         ]);

         $tagName = request('tag');
         if( $tagName )
         {
            $tag = Tag::where('name', $tagName)->first();  
            if( !$tag )
                $tag = Tag::create([ 'name' => $tagName ]);
            $note->tag()->attach($tag->id);
         }
     
         return redirect("/notes/" . $note->id);
    }

    public function destory(Note $note)
    {
        $note->delete();
        return redirect('/notes');
    }

    public function duplicate(Note $note)
    { 
        $generator = new GenerateTitle();
        $newTitle = $generator->generateTitle($note->title);
        $newNote = $note->replicate();
        $newNote->title = $newTitle;
        $newNote->save();
            
        return redirect('/notes/'.$newNote->id);
    }
}
