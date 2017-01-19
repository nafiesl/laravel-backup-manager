@extends('layouts.app')

@section('title',trans('backup.index_title'))

@section('content')
<h1 class="page-header">{{ trans('backup.index_title') }}</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('backup.list') }}</h3></div>
            <table class="table table-condensed">
                <thead>
                    <th>#</th>
                    <th>{{ trans('backup.file_name') }}</th>
                    <th>{{ trans('backup.file_size') }}</th>
                    <th>{{ trans('backup.created_at') }}</th>
                    <th class="text-center">{{ trans('backup.actions') }}</th>
                </thead>
                <tbody>
                    @forelse($backups as $key => $backup)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $backup->getFilename() }}</td>
                        <td>{{ $backup->getSize() }} Bytes</td>
                        <td>{{ date('Y-m-d H:i:s', $backup->getMTime()) }}</td>
                        <td class="text-center">
                            <a href="{{ route('backups.index', ['action' => 'delete', 'file_name' => $backup->getFilename()]) }}"
                                id="del_{{ $backup->getFilename() }}"
                                class="btn btn-danger btn-xs"
                                title="{{ trans('backup.delete') }}">X</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">{{ trans('backup.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        @if (Request::get('action') == 'delete' && Request::has('file_name'))
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('backup.delete') }}</h3>
                </div>
                <div class="panel-body">
                    <p>{!! trans('backup.sure_to_delete_file', ['filename' => Request::get('file_name')]) !!}</p>
                </div>
                <div class="panel-footer">
                    <a href="{{ route('backups.index') }}" class="btn btn-default">{{ trans('backup.cancel_delete') }}</a>
                    <form action="{{ route('backups.destroy', Request::get('file_name')) }}" method="post" class="pull-right">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="file_name" value="{{ Request::get('file_name') }}">
                        <input type="submit" class="btn btn-danger" value="{{ trans('backup.confirm_delete') }}">
                    </form>
                </div>
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('backups.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="file_name" class="control-label">{{ trans('backup.create') }}</label>
                        <input type="text" name="file_name" class="form-control" placeholder="{{ date('Y-m-d_Hi') }}">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="{{ trans('backup.create') }}" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
