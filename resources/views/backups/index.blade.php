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
                </thead>
                <tbody>
                    @forelse($backups as $key => $backup)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $backup->getFilename() }}</td>
                        <td>{{ $backup->getSize() }} Bytes</td>
                        <td>{{ date('Y-m-d H:i:s', $backup->getMTime()) }}</td>
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
