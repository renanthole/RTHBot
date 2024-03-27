<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quiz_id',
        'question_id',
        'next_id',
        'free',
        'option'
    ];

    public function quizz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function nextQuestion(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'next_id')->withDefault();
    }

    public function finishedOption()
    {
        return is_null($this->next_id) ? 'Finalizar atendimento' : $this->nextQuestion->title;
    }

    public function followUpQuestion()
    {
        return is_null($this->next_id) ? 'Foi um prazer estar em contato! Mal posso esperar para nos encontrarmos novamente. Até breve!' : $this->nextQuestion->question;
    }
}
