<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shotshare:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user (useful if registration is disabled).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => text(
                'What is your name?',
                'John Doe',
                required: true,
            ),
            'email' => text(
                'What is your email?',
                'john.doe@example.com',
                required: true,
                validate: fn ($value) => ! filter_var($value, FILTER_VALIDATE_EMAIL)
                    ? 'Must be a valid email'
                    : null
            ),
            'password' => Hash::make(password(
                'Enter Password',
                required: true,
            )),
        ]);

        if ($user) {
            info('Successfully created user');
        } else {
            error('Failed to create user');
        }
    }
}
