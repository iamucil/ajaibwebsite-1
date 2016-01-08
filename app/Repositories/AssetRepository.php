<?php
namespace App\Repositories;

use App\User;
use Storage;
use File;

class AssetRepository
{
    public function __construct()
    {
        $this->storage_disk = env('ASSET_STORAGE');
    }

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
        $destinationPath = 'files/'.$this->directoryNaming($userId);

        if ($request->hasFile('image_file'))
        {
            $file 		= $request->file('image_file');
            $fileName 	= $file->getClientOriginalName();
            $fileExt 	= $file->getClientOriginalExtension();
            $fileRename = $this->fileNaming($fileName) . '.' . $fileExt;
            $resultUpload = Storage::disk($this->storage_disk)->put($destinationPath.'/'.$fileRename, File::get($file));

            if ($resultUpload) {
                $user = User::find($userId);
                $user->photo = "/".$destinationPath."/".$fileRename;
                $resultUpdate=$user->save();
            }
        }

        return $resultUpdate;
    }
}
?>