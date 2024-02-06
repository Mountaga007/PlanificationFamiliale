<?php

namespace App\Models;

use App\Http\Controllers\ForumCommunicationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'texte',
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function forum()
        {
            return $this->belongsTo(Forum_Communication::class);
        }
}
