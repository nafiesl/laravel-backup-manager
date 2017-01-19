<?php

namespace App\Http\Controllers;

use BackupManager\Filesystems\Destination;
use BackupManager\Manager;
use Illuminate\Http\Request;
use League\Flysystem\FileExistsException;

class BackupsController extends Controller
{
    public function index(Request $request)
    {
        if (!file_exists(storage_path('app/backup/db'))) {
            $backups = [];
        } else {
            $backups = \File::allFiles(storage_path('app/backup/db'));

            // Sort files by modified time DESC
            usort($backups, function($a, $b) {
                return -1 * strcmp($a->getMTime(), $b->getMTime());
            });
        }

        return view('backups.index',compact('backups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file_name' => 'max:30|regex:/^[\w._-]+$/'
        ]);

        try {
            $manager = app()->make(Manager::class);
            $fileName = $request->get('file_name') ?: date('Y-m-d_Hi');

            $manager->makeBackup()->run('mysql', [
                    new Destination('local', 'backup/db/' . $fileName)
                ], 'gzip');

            // if ($fileName)
            //     flash()->success('Backup berhasil dilakukan, nama File : ' . $fileName);

            return redirect()->route('backups.index');
        } catch (FileExistsException $e) {
            // flash()->error('Database tidak dapat dibackup dengan Nama File yang sama.');
            return redirect()->route('backups.index');
        }
    }

}
