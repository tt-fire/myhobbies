<?php

namespace App\Policies;

use App\Hobby;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HobbyPolicy
{
    use HandlesAuthorization;



    // für front-end:
    public function before($user, $ability) {
        if ($user->rolle === 'admin') {
            return true;
            //= admin darf alles!!!
        }
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     * 
     * sind avyilities - was ein user kann!
     */
    public function viewAny(User $user)
    {
        //bezieht sich auf Index Funktion im Controller!
        //da jeder alles sehen darf, kein Änderungsbedarf!
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Hobby  $hobby
     * @return mixed
     */
    public function view(User $user, Hobby $hobby)
    {
        //bezieht sich auf die show (=detail) funktion im Controller!
        //da jeder alles sehen darf, kein Änderungsbedarf!
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // = store vom controller
        // jeder der eingeloggt ist darf neues anlegen!
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Hobby  $hobby
     * @return mixed
     */
    public function update(User $user, Hobby $hobby)
    {
        // = update vom controller
        // nur der eigene darf seine updaten!:=
        return $user->id ==== $hobby->user_id; // nur wen user id = hobby-user ID dann darf man bearbeiten!

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Hobby  $hobby
     * @return mixed
     */
    public function delete(User $user, Hobby $hobby)
    {
        // = destroy vom controller
        return $user->id ==== $hobby->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Hobby  $hobby
     * @return mixed
     */
    public function restore(User $user, Hobby $hobby)
    {
        //für "soft-delete?"
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Hobby  $hobby
     * @return mixed
     */
    public function forceDelete(User $user, Hobby $hobby)
    {
        //für "soft-delete?"
    }
}
