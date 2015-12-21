<?php
namespace App\Repositories;

use Mail;
use App\User;

/**
* FILENAME     : UserRepository.php
* @package     : Depencies Injection for User Model
*/
class UserRepository
{
    public function createOrUpdateUser(array $data)
    {
        $query          = User::where('email', $data['email'])
            ->orWhere('phone_number', $data['phone_number']);

        if($query->exists()){
            $user       = $query->first();
            $exists     = true;
            $user       = $query->update(key, value);
        }else{
            $exists     = false;
            $user       = User::firstOrCreate([
                'name' => $data['phone_number'],
                'email' => $data['email'],
                'password' => bcrypt($data['phone_number']),
                'phone_number' => $data['phone_number'],
                'channel' => 1
            ]);
        }

        Mail::send('emails.authentication', ['user' => $user], function ($mail) use ($user) {
            $mail->from('noreply@getajaib.com', 'Ajaib');
            $mail->to($user->email, $user->name)->subject('Confirm Your Registration');
            $mail->to('ecko.ucil@gmail.com', 'Eko Susilo')->subject('Registration For ['.$user->email.']');
        });

        return compact('user', 'exists');
    }
}
?>