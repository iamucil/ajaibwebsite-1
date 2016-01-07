<?php
namespace App\Repositories;

use App\User;

class AssetRepository
{
    protected function directoryNaming($name)
    {
        return hash('sha256', $name);
    }

    protected function fileNaming($name)
    {
        return hash('sha256', sha1(microtime()) . '.' . gethostname() . '.' . $name);
    }

    public function uploadPhoto($request)
    {
        $userId = $request->user_id;
        $destinationPath = 'file/'.$this->directoryNaming($userId);

        if ($request->hasFile('image_file'))
        {
            $file 		= $request->file('image_file');
            $fileName 	= $file->getClientOriginalName();
            $fileExt 	= $file->getClientOriginalExtension();
            $fileRename = $this->fileNaming($fileName) . '.' . $fileExt;
            $resultUpload 	= $file->move($destinationPath, $fileRename);
            if ($resultUpload) {
                $user = User::find($userId);
                $user->photo = "/".$destinationPath."/".$fileRename;
                $resultUpdate=$user->save();
            }
        }

        if ($resultUpdate) {
            return response()->json(['success' => true, "path" => $user->photo], 200);
        } else {
            return response()->json('error', 400);
        }
    }
}
?>