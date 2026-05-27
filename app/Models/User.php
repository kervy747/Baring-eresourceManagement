<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['fname', 'lname', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool {
      return $this->role === 'admin';
    }

    public function isUser(): bool {
      return $this->role === 'user';
    }

    public function isSuperAdmin(): bool {
        return $this->role === 'superadmin';
    }

    public function fullName(): string {
      return $this->fname . ' ' . $this->lname;
    }

    public function role(): string {
      return $this->role;
    }

    public function isAdmins(): bool {
      return $this->role === 'superadmin' || 
      $this->role === 'admin';
    }
  
}
