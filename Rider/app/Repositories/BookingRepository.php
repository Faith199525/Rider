<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Notifications\EmailVerification;

class BookingRepository
{
    public function getUser($id)
    {
        return User::find($id);
    }

    public function getUserByEmail($email)
    {
        return User::where('email',$email)->first();
    }

    public function store($request)
    {
        $user = User::create($request);

        // $user->sendEmailVerificationNotification();
        $token = time() . \Str::random(20) . time() . rand(0, 19098987);

        \DB::table("email_verifies")
            ->insert([
                "email" => $user->email,
                "token" => $token,
                "created_at" => \Carbon\Carbon::now()
            ]);

        $registered_user = array("user_id" => $user->id);
        
        $input = array_merge($request, $registered_user); 

        $profile = Profile::create($input);

        $user->notify(new EmailVerification($token));

        $role = new RoleUser;
        $role->role_id = Role::where('name', 'investor')->first()->id;
        $user->role()->save($role);

        return $user;
    }

    public function changePassword($user, $hashedNewPassword)
    {
        return $user->update([
            'password' => $hashedNewPassword
        ]);
    }

    public function update($profile, $input)
    {
    
        $profile->firstname = $input['firstname'];
        $profile->lastname =  $input['lastname'];
        $profile->gender = $input['gender'];
        $profile->phone_number = $input['phone_number'];
        $profile->image = array_key_exists("image",$input) ? $input['image'] : $profile->image;
        $profile->dob = $input['dob'];
        $profile->address = $input['address'];
        $profile->bank = $input['bank'];
        $profile->account_number = $input['account_number'];
        $profile->account_name = $input['account_name'];
        $profile->kin_firstname = $input['kin_firstname'];
        $profile->kin_lastname = $input['kin_lastname'];
        $profile->kin_gender = $input['kin_gender'];
        $profile->kin_phone_number = $input['kin_phone_number'];
        $profile->kin_dob = $input['kin_dob'];
        $profile->kin_email = $input['kin_email'];
        $profile->kin_relationship = $input['kin_relationship'];
        $profile->save();
        
        return  $profile;
    }
}


