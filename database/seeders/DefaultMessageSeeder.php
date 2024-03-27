<?php

namespace Database\Seeders;

use App\Models\DefaultMessage;
use Illuminate\Database\Seeder;

class DefaultMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultMessage::create([
            'title' => 'Encerramento de chat',
            'message' => 'Olá! Parece que houve uma pausa na nossa conversa. Se precisar de mais alguma coisa, estou aqui para ajudar. Sinta-se à vontade para retomar a qualquer momento!',
            'created_at' => now()
        ]);
    }
}
