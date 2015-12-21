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
        $query = User::where('email', $data['email'])
            ->orWhere('phone_number', $data['phone_number']);

        $verificationCode = $this->generateVerificationCode();

        if ($query->exists()) {
            $query->update(['verification_code' => $verificationCode]);
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
                'verification_code' => $verificationCode
            ]);
        }

        Mail::send('emails.authentication', ['user' => $user], function ($mail) use ($user) {
            $mail->from('noreply@getajaib.com', 'Ajaib');
            $mail->to($user->email, $user->name)->subject('Confirm Your Registration');
        });

        return compact('user', 'exists');
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