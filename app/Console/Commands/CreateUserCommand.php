<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {name : Nombre del usuario} {email : E-mail del usuario} {password : Contraseña del Usuario}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo usuario';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ];

        $rules = [
            'name' => 'required|min:2|string',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => ['required', Password::min(8)->letters()->numbers()],
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->stopOnFirstFailure()->fails()) {
            $this->error($validator->errors()->first());

            return;
        }
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        $this->info('Usuario creado satisfactoriamente');
    }
}
