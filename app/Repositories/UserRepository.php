<?php
namespace App\Repositories;

use Mail;
use App\User;
use App\Role;
use App\Country;
use App\Http\Requests;
use Twilio;

/**
 * FILENAME     : UserRepository.php
 * @package     : Depencies Injection for User Model
 */
class UserRepository
{
    public function createOrUpdateUser(array $data)
    {
        $role           = Role::where('name', '=', 'users');
        $verification_code      = $this->generateVerificationCode();
        if($role->exists()){
            $country            = Country::find($data['country_id']);
            $calling_code       = $country->calling_code;
            $regexp             = sprintf('/^[(%d)]{%d}+/i', $calling_code, strlen($calling_code));
            $regex              = sprintf('/^[(%s)]{%s}[0-9]{3,}/i', $calling_code, strlen($calling_code));
            $data['phone_number']   = preg_replace('/\s[\s]+/', '', $data['phone_number']);
            $data['phone_number']   = preg_replace('/[\s\W]+/', '', $data['phone_number']);
            $data['phone_number']   = preg_replace('/^[\+]+/', '', $data['phone_number']);
            $data['channel']        = hash('crc32b', bcrypt(uniqid(rand()*time())));
            $data['phone_number']   = preg_replace($regexp, '', $data['phone_number']);
            $data['phone_number']   = preg_replace('/^[(0)]{0,1}/i', $calling_code.'\1', $data['phone_number']);
            $data['channel']    = preg_replace($regexp, '${2}', $data['phone_number']);
            $data['channel']    = hash('crc32b', bcrypt(uniqid($data['channel'])));
            $data['channel']    = preg_replace('/(?<=\w)([A-Za-z])/', '-\1', $data['channel']);
            $data['status']     = false;
            $data['name']       = preg_replace($regexp, '${2}', $data['phone_number']);
            $data['verification_code']  = $this->generateVerificationCode();
            $data['verification_code']  = str_repeat('*', 6);
            $data['password']           = bcrypt('+'.$data['phone_number']);
            // merge all request input
            request()->merge($data);

            // check whether data user is exists
            $query = User::where('email', request()->email)
                ->orWhere('phone_number', request()->phone_number);

            /**
             * if user is exists reset verification data to default and status to false
             * otherwise insert new data into table users
             */

            if ($query->exists()) {
                $user   = $query->first();
                $exists = true;
                if((bool)$user->status === true){
                    $query->update([
                        'verification_code' => $verification_code,
                        // 'status' => false
                    ]);
                    $mail_template  = 'emails.authentication';
                    $sender         = env('EMAIL_NOREPLY','noreply@getajaib.com');
                    $user           = $query->first();
                    Twilio::message('+'.$user->phone_number, 'Your Ajaib Verification code is '.$user->verification_code);
                }else{
                    $mail_template  = 'emails.greeting';
                    $sender         = env('EMAIL_FROM','noreply@getajaib.com');
                }
            } else {
                $exists = false;
                // $input  = request()->except(['_token', 'role_id', 'retype-password', 'country_name', 'ext_phone', 'calling_code']);
                $input      = request()->only(['phone_number', 'channel', 'status', 'name', 'verification_code', 'password', 'email']);
                $user = User::firstOrCreate($input);
                $mail_template  = 'emails.greeting';
                $sender         = env('EMAIL_FROM','noreply@getajaib.com');
            }

            /**
             * And finnaly send email greeting to registered user
             */
            Mail::send($mail_template, ['user' => $user], function ($mail) use ($user, $sender) {
                $mail->from($sender, 'Ajaib');
                $mail->to($user->email, $user->name)->subject('Greeting from Ajaib');
            });

            /**
             * After action users succeed assign registered user into role user
             * set role to end user
             */
            $role_user  = $role->first();
            if(!$user->hasRole($role_user->name)){
                $user->roles()->attach($role_user->id);
            }

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
            Twilio::message('+'.$user->phone_number, 'Your Ajaib Verification code is '.$user->verification_code);
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