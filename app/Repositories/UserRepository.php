<?php
namespace App\Repositories;

use Mail;
use App\User;
use App\Role;

/**
 * FILENAME     : UserRepository.php
 * @package     : Depencies Injection for User Model
 */
class UserRepository
{
    public function createOrUpdateUser(array $data)
    {
        $role           = Role::where('name', '=', 'users');
        if($role->exists()){
            $query = User::where('email', $data['email'])
                ->orWhere('phone_number', $data['phone_number']);

            $verificationCode = $this->generateVerificationCode();

            if ($query->exists()) {
                $query->update([
                    'verification_code' => '******',
                    'status' => false
                ]);
                $user   = $query->first();
                $exists = true;
            } else {
                $exists = false;
                $user = User::firstOrCreate([
                    'name' => $data['phone_number'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['phone_number']),
                    'phone_number' => $data['phone_number'],
                    'channel' => 1,
                    'verification_code' => '******',
                    'country_id' => $data['country_id'],
                ]);
            }

            Mail::send('emails.greeting', ['user' => $user], function ($mail) use ($user) {
                $mail->from('noreply@getajaib.com', 'Ajaib');
                $mail->to($user->email, $user->name)->subject('Greeting from Ajaib');
            });
            return compact('user', 'exists');
        }else{
            return null;
        }
    }

    public function setActive($id)
    {
        $verificationCode = $this->generateVerificationCode();
        $user       = User::find($id);
        $user->verification_code    = $verificationCode;
        $user->status               = true;
        if($user->save()) {
            Mail::send('emails.authentication', ['user' => $user], function ($mail) use ($user) {
                $mail->from('noreply@getajaib.com', 'Ajaib');
                $mail->to($user->email, $user->name)->subject('Confirm Your Registration');
            });
            return true;
        }else{
            return false;
        }

    }

    protected function generateVerificationCode()
    {
        $length = 6;
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $arrVerificationCode = [];
        for ($i = 0; $i < $length; $i++) {
            $char = $characters[rand(0, $charactersLength - 1)];
            if($char == '0' OR $char == '1' OR in_array($char, $arrVerificationCode)){
                $char = $characters[rand(0, $charactersLength - 1)];
            }
            $arrVerificationCode[] = $char;
        }
        $verificationCode  = implode("",$arrVerificationCode);
        $query = User::where('verification_code', $verificationCode);
        if($query->exists()){
            $verificationCode  = self::generateVerificationCode();
        }
        return $verificationCode;
    }
}

?>