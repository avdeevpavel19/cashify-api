<?php

// @formatter:off

/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models {
    /**
     * App\Models\Profile
     *
     * @property int $id
     * @property int $user_id
     * @property string|null $first_name
     * @property string|null $last_name
     * @property string|null $birthday
     * @property string|null $gender
     * @property string|null $country
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Profile onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereBirthday($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCountry($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereFirstName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereGender($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLastName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Profile withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Profile withoutTrashed()
     */
    class Profile extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $email
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property mixed $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
     */
    class User extends \Eloquent
    {
    }
}

