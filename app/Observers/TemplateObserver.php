<?php
namespace App\Observers;

use App\User;

class TemplateObserver
{
    
    /**
     * Listen to the User creating event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user)
    {
        //code...
    }

     /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //code...
    }

    /**
     * Listen to the User updating event.
     *
     * @param  User  $user
     * @return void
     */
    public function updating(User $user)
    {
        //code...
    }

    /**
     * Listen to the User updated event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //code...
    }

    /**
     * Listen to the User saving event.
     *
     * @param  User  $user
     * @return void
     */
    public function saving(User $user)
    {
        //code...
    }

    /**
     * Listen to the User saved event.
     *
     * @param  User  $user
     * @return void
     */
    public function saved(User $user)
    {
        //code...
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //code...
    }

    /**
     * Listen to the User deleted event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //code...
    }

    /**
     * Listen to the User restoring event.
     *
     * @param  User  $user
     * @return void
     */
    public function restoring(User $user)
    {
        //code...
    }

    /**
     * Listen to the User restored event.
     *
     * @param  User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //code...
    }
}