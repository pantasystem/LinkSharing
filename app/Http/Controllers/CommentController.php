<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Comment;
use App\Services\NotificationService;

class CommentController extends Controller
{


    public function replyToNote(NotificationService $service, Request $request, $noteId)
    {
        $note = Note::findOrFail($noteId);
        $user = Auth::user();
        $comment = $user->comments()->create([
            'commentable_id' => $note->id,
            'text' => $request->input('text'),
        ]);
        $service->create($user, $comment);

        return $comment;
    }

    public function findAllByNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        return $note->comments()->simplePaginate();
    }

    public function findAllByNoteAndComment($noteId, $commentId)
    {
        return $this->getComment($noteId, $commentId)->comments()->simplePaginate();
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
        return $note->comments()->findOrFail($commentId);
    }
  
}
