<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasKycCheck;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, CausesActivity, HasApiTokens, HasKycCheck;

    /**
     * The application has two types of users which can either be `Agents` or `Admins`
     *<p>The role management of this system is divided into these as the groups.
     * <p>Therefore, each role created can either be an Admin (always the first index) or an Agent (the second index).
     */
    const GROUPS = ['Admins', 'Agents'];
    const ALL_STATUS = ['ACTIVE', 'INACTIVE', 'SUSPENDED', 'DISABLED'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $with = ['roles'];

    protected static string $logName = 'User';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['name'];

//    Relationships

    public function superAgent(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agents(): HasMany
    {
        return $this->hasMany(User::class, 'super_agent_id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function walletTransactions(): HasManyThrough
    {
        return $this->hasManyThrough(WalletTransaction::class, Wallet::class)
            ->where('wallet_transactions.status', Status::SUCCESSFUL);
    }

    public function terminals(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }

// Attributes

    /**
     * The getter that return accessible URL for user photo.
     *
     * @return Attribute
     */
    public function avatar(): Attribute
    {
        return Attribute::get(
            fn($value) => !is_null($value) ? $value
                : asset('build/assets/images/'. strtolower($this->gender) .'.jpeg')
        );
    }

    public function name(): Attribute
    {
        return Attribute::get(
            fn($value) => "$this->first_name $this->other_names"
        );
    }

    public function roleName(): Attribute
    {
        $roles = $this->getRoleNames();

        return Attribute::get(
            fn($value) => $roles->count() < 1 ? null : $roles[0]
        );
    }

    public function roleType(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->roles->first()->type
        );
    }

    public function isActive(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->status == 'ACTIVE'
        );
    }

    public function password(): Attribute
    {
        return Attribute::set(fn($value) => Hash::make($value));
    }

    public function pin(): Attribute
    {
        return Attribute::set(fn($value) => Hash::make($value));
    }

    public function adminPin(): Attribute
    {
        return Attribute::set(fn($value) => Hash::make($value));
    }

//    Methods

    /**
     * check that the user is part of agents roles
     * @return bool
     */
    public function isAgentGroup(): bool
    {
        $agents = Role::query()->where('type', self::GROUPS[1])->pluck('name')->toArray();

        return $this->hasAnyRole($agents);
    }

    public function isAdmin(): bool
    {
        return $this->role_type == self::GROUPS[0];
    }

    /**
     * Change the terminal status to the opposite value
     */
    public function changeStatus(string $new_status = null): void
    {
        $this->status = $new_status;
        $this->save();
    }

    /**
     * Generate the api token for the terminal authentication.
     *
     * @param Terminal $terminal
     * @return array<string,string> of the token <b>value</b>, <b>type</b> and <b>expires_at</b>
     */
    public function generateToken(Terminal $terminal): array
    {
        return [
            'value'  => $this->createToken("$terminal->tid personal token")->plainTextToken,
            'type'    => 'Bearer',
            'expires_at' => now()->addMinutes(config('sanctum.expiration'))->toDateTimeString()
        ];
    }

    /**
     * Set the initial user password to the specified user's <b>first_name</b>
     * combined with the last 5 digits of their <b>phone_number</b>.
     *
     * @return string
     */
    public function getInitialPassword(): string
    {
        return App::isProduction() ?
            str($this->phone)->substr(-5)->prepend($this->first_name)->lower() :
            'password4231';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Users')
            ->logOnly(['name', 'email'])
            ->logOnlyDirty();
    }


    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('other_names', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }

    public function scopeAgent(Builder $builder)
    {
        $builder->whereRelation('roles', 'type', User::GROUPS[1]);
    }

    public function scopeStaff(Builder $builder)
    {
        $builder->whereRelation('roles', 'type', User::GROUPS[1]);
    }
}
