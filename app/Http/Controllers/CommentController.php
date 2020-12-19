<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Note;
use App\Models\Comment;
use App\Services\NotificationService;
use App\Events\Replied;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    public function replyToNote(CreateCommentRequest $request, $noteId)
    {
        $note = Note::findOrFail($noteId);
        $user = Auth::user();
        $comment = new Comment($request->only('text'));
        $comment->author()->associate($user);
        $note->comments()->save($comment);
        Replied::dispatch($comment);

        return $comment->load(['author']);
    }

    public function replyToComment(CreateCommentRequest $request, $noteId, $commentId)
    {
        $replyToComment = Note::findOrFail($noteId)->comments()
            ->findOrFail($commentId);
        $user = Auth::user();
        $comment = new Comment($request->only('text'));
        $comment->author()->associate($user);
        $replyToComment->comments()->save($comment);
        Replied::dispatch($comment);

        return $comment->load(['author']);
        
    }

    public function findAllByNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        return $note->comments()->with(['author'])->simplePaginate();
    }

    public function findAllByNoteAndComment($noteId, $commentId)
    {
        return $this->getComment($noteId, $commentId)->comments()->with(['author'])->simplePaginate();
    }

    public function findComments($commentId){
        return Comment::findOrFail($commentId)->comments()->with(['author'])->simplePaginate();
    }

    public function show($noteId, $commentId)
    {
        return $this->getComment($noteId, $commentId);
    }

    public function delete($noteId, $commentId)
    {
        $comment = $this->getComment($noteId, $commentId);
        $comment->delete();
    }

    private function getComment($noteId, $commentId): Comment{

        $note = Note::findOrFail($noteId);
        return $note->comments()->with(['author'])->findOrFail($commentId);
    }
  
}
