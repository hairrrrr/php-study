<?php

namespace App\Providers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Model::preventLazyLoading();
        //Paginator::useBooststrapFive();

        Gate::define('trash', function(User $user, int $id){
            $note = Note::onlyTrashed()->find($id);
            return $note && $note->user_id === Auth::id();
        });
        // Gate::define('edit', function(User $user, Note $v){
        //     return $note->user->is(Auth::user());
        // });
    }
}
