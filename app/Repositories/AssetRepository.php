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

    public function downloadFile($pathFile)
    {
        $file = File::get($pathFile);
        $type = File::mimeType($pathFile);

        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
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
                $user->photo = $destinationPath."/".$fileRename;
                $resultUpdate=$user->save();
            }
        }

        return $resultUpdate;
    }

    public function uploadAttachment($request) {
        if ($request->hasFile('file'))
        {
            $userId = $request->user_id;
            $destinationPath = 'files/'.$this->directoryNaming($userId);

            $file       = $request->file('file');
            $fileName 	= $file->getClientOriginalName();
            $fileExt 	= strtolower($file->getClientOriginalExtension());
            $fileRename = $this->fileNaming($fileName) . '.' . $fileExt;
            switch ($fileExt) {
                case 'jpg'||'png'||'bmp'||'gif'||'jpeg';
                    $destinationPath.='/'.$fileRename;
                    break;
            }
            $resultUpload = Storage::disk($this->storage_disk)->put($destinationPath, File::get($file));
            if ($resultUpload) {
                return $destinationPath;
            } else {
                return false;
            }
        }
    }
}
?>