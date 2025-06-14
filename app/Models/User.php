<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use App\Notifications\UserVerifyNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $phone
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $dob
 * @property int|null $gender
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property int $is_active
 * @property int $is_verified
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Candidate|null $candidate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $candidateSkill
 * @property-read int|null $candidate_skill_count
 * @property-read mixed $avatar
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereState($value)
 *
 * @property-read \App\Models\Company|null $company
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property string $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Language[] $candidateLanguage
 * @property-read int|null $candidate_language_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLanguage($value)
 *
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int $profile_views
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavouriteCompany[] $followings
 * @property-read int|null $followings_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfileViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStateId($value)
 *
 * @property-read mixed $city_name
 * @property-read mixed $country_name
 * @property-read mixed $state_name
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $linkedin_url
 * @property string|null $google_plus_url
 * @property string|null $pinterest_url
 * @property int $is_default
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGooglePlusUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLinkedinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePinterestUrl($value)
 *
 * @property string|null $stripe_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTwitterUrl($value)
 *
 * @property string|null $region_code
 * @property-read bool $is_online_profile_availbal
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegionCode($value)
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, Billable;

    const DARK_MODE = 1;

    const LIGHT_MODE = 0;

    const PROFILE = 'profile-pictures';

    const ACTIVE = 1;

    const LANGUAGES = [
        'ar' => 'Arabic',
        'zh' => 'Chinese',
        'en' => 'English',
        'fr' => 'French',
        'de' => 'German',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'es' => 'Spanish',
        'tr' => 'Turkish',
    ];

    const LANGUAGES_IMAGE = [
        'en' => 'assets/img/united-states.svg',
        'es' => 'assets/img/spain.svg',
        'fr' => 'assets/img/france.svg',
        'de' => 'assets/img/germany.svg',
        'ru' => 'assets/img/russia.svg',
        'pt' => 'assets/img/portugal.svg',
        'ar' => 'assets/img/iraq.svg',
        'zh' => 'assets/img/china.svg',
        'tr' => 'assets/img/turkey.svg',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'gender',
        'country_id',
        'state_id',
        'city_id',
        'is_active',
        'is_verified',
        'phone',
        'email_verified_at',
        'owner_id',
        'owner_type',
        'language',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'google_plus_url',
        'pinterest_url',
        'is_default',
        'region_code',
    ];

    /**
     * @var array
     */
    protected $appends = ['full_name', 'avatar', 'country_name', 'state_name', 'city_name'];

    protected $with = ['media', 'country', 'city', 'state'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getCountryNameAttribute()
    {
        if (! empty($this->country)) {
            return $this->country->name;
        }
    }

    public function getStateNameAttribute()
    {
        if (! empty($this->state)) {
            return $this->state->name;
        }
    }

    public function getCityNameAttribute()
    {
        if (! empty($this->city)) {
            return $this->city->name;
        }
    }

    /**
     * @return mixed
     */
    public function getAvatarAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PROFILE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/infyom-logo.png');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'email.regex' => 'Please enter valid email.',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'dob' => 'date',
        'gender' => 'integer',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'phone' => 'string',
        'email_verified_at' => 'datetime',
        'owner_id' => 'integer',
        'owner_type' => 'string',
        'language' => 'string',
        'facebook_url' => 'string',
        'twitter_url' => 'string',
        'linkedin_url' => 'string',
        'google_plus_url' => 'string',
        'pinterest_url' => 'string',
        'is_default' => 'boolean',
        'region_code' => 'string',
    ];

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function candidate(): HasOne
    {
        return $this->hasOne(Candidate::class, 'user_id', 'id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function candidateSkill(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills', 'user_id', 'skill_id');
    }

    public function candidateLanguage(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'candidate_language', 'user_id', 'language_id');
    }

    public function followings(): HasMany
    {
        return $this->hasMany(FavouriteCompany::class, 'user_id');
    }

    public function getIsOnlineProfileAvailbalAttribute(): bool
    {
        if (empty($this->facebook_url) && empty($this->twitter_url) && empty($this->linkedin_url) && empty($this->google_plus_url) && empty($this->pinterest_url)) {
            return false;
        }

        return true;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserVerifyNotification($this));  //pass the currently logged in user to the notification class
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordReset($token));
    }
}
