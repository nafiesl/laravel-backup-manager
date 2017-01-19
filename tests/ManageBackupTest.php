<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageBackupTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_create_new_backup_file()
    {
        $this->signInAsAdmin();

        $this->visit(route('backups.index'));
        $this->seePageIs(route('backups.index'));
        $this->type('new_backup.1231231231','file_name');
        $this->press(trans('backup.create'));

        $this->seePageIs(route('backups.index'));

        $this->assertTrue(file_exists(storage_path('app/backup/db') . '/new_backup.1231231231.gz'));
        unlink(storage_path('app/backup/db') . '/new_backup.1231231231.gz');
        $this->assertFalse(file_exists(storage_path('app/backup/db') . '/new_backup.1231231231.gz'));
    }

    /** @test */
    public function it_can_delete_a_backup_file()
    {
        $this->signInAsAdmin();

        $this->visit(route('backups.index'));
        $this->seePageIs(route('backups.index'));
        $this->type('new_backup1231231231','file_name');
        $this->press(trans('backup.create'));

        $this->seePageIs(route('backups.index'));
        $this->assertTrue(file_exists(storage_path('app/backup/db') . '/new_backup1231231231.gz'));

        $this->click('del_new_backup1231231231');
        $this->press(trans('backup.confirm_delete'));
        $this->assertFalse(file_exists(storage_path('app/backup/db') . '/new_backup1231231231.gz'));
    }

    /** @test */
    public function it_can_upload_a_backup_file()
    {
        $this->signInAsAdmin();

        $this->visit(route('backups.index'));
        $this->seePageIs(route('backups.index'));
        $this->attach(storage_path('app') . '/backup_test_file.gz', 'backup_file');
        $this->press(trans('backup.upload'));

        $this->seePageIs(route('backups.index'));
        $this->assertTrue(file_exists(storage_path('app/backup/db') . '/backup_test_file.gz'));
        unlink(storage_path('app/backup/db') . '/backup_test_file.gz');
        $this->assertFalse(file_exists(storage_path('app/backup/db') . '/backup_test_file.gz'));
    }
}
