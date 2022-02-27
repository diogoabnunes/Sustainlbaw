<?php

namespace App\Models;

use Auth;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    use CanResetPassword;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "user";
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role', 'active', 'image_path', 'user_search'
    ];


    public function getId()
    {
        return $this->user_id;
    }

    public function getAvatar()
    {
        $path = $this->image_path;
        if (file_exists($path))
            return $path;
        return "../assets/fotoperfil.jpeg";
    }
    //TODO Eliminar
    public function getAdminAvatar()
    {
        $path = $this->image_path;
        if ($path != '')
            return url('storage/images/' . $this->image_path);
        return  url('storage/images/' . "fotoperfil.jpeg");
        //  "../assets/fotoperfil.jpeg";
    }


    public function isEditor()
    {
        if (!Auth::check()) return false;
        return $this->role == 'Editor' || $this->role == 'Admin';
    }

    public function isAdmin()
    {
        if (!Auth::check()) return false;
        return $this->role == 'Admin';
    }

    public function isInactive()
    {
        return $this->active == false;
    }

    public function isActive()
    {
        return $this->active == true;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function isOwner()
    {
        if (Auth::check()) return true;
        else return false;
    }

    // protected $hidden = [
    //     'password',
    // ];
}
