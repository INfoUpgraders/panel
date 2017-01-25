{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- Permission is hereby granted, free of charge, to any person obtaining a copy --}}
{{-- of this software and associated documentation files (the "Software"), to deal --}}
{{-- in the Software without restriction, including without limitation the rights --}}
{{-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell --}}
{{-- copies of the Software, and to permit persons to whom the Software is --}}
{{-- furnished to do so, subject to the following conditions: --}}

{{-- The above copyright notice and this permission notice shall be included in all --}}
{{-- copies or substantial portions of the Software. --}}

{{-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR --}}
{{-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, --}}
{{-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE --}}
{{-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER --}}
{{-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, --}}
{{-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE --}}
{{-- SOFTWARE. --}}
@extends('layouts.admin')

@section('title')
    Add New Service Pack
@endsection

@section('content')
<div class="col-md-12">
    <ul class="breadcrumb">
        <li><a href="/admin">Admin Control</a></li>
        <li><a href="/admin/services">Services</a></li>
        <li><a href="{{ route('admin.services.packs') }}">Packs</a></li>
        <li><a href="{{ route('admin.services.packs.service', $service->id) }}">{{ $service->name }}</a></li>
        <li><a href="{{ route('admin.services.packs.option', $option->id) }}">{{ $option->name }}</a></li>
        <li class="active">{{ $pack->name }} ({{ $pack->version }})</li>
    </ul>
    <h3 class="nopad">Manage Service Pack</h3><hr />
    <form action="{{ route('admin.services.packs.edit', $pack->id) }}" method="POST">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label">Pack Name:</label>
                <div>
                    <input type="text" name="name" value="{{ old('name', $pack->name) }}" placeholder="My Awesome Pack" class="form-control" />
                    <p class="text-muted"><small>The name of the pack which will be seen in dropdown menus and to users.</small></p>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label">Pack Version:</label>
                <div>
                    <input type="text" name="version" value="{{ old('version', $pack->version) }}" placeholder="v0.8.1" class="form-control" />
                    <p class="text-muted"><small>The version of the program included in this pack.</small></p>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label">Description:</label>
                <div>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $pack->description) }}</textarea>
                    <p class="text-muted"><small>Provide a description of the pack which will be shown to users.</small></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Associated Service Option:</label>
                <select name="option" class="form-control">
                    @foreach($services as $service => $options)
                        <option disabled>{{ $service }}</option>
                        @foreach($options as $option)
                            <option value="{{ $option['id'] }}" @if($pack->option === (int) $option['id'])selected="selected"@endif>&nbsp;&nbsp; -- {{ $option['name'] }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 fuelux">
                <label class="control-label">&nbsp;</label>
                <div>
                    <label class="checkbox-formheight checkbox-custom checkbox-inline highlight" data-initialize="checkbox">
                        <input class="sr-only" type="checkbox" name="selectable" value="1" @if($pack->selectable)checked="checked"@endif> User Selectable
                    </label>
                </div>
            </div>
            <div class="col-md-3 fuelux">
                <label class="control-label">&nbsp;</label>
                <div>
                    <label class="checkbox-formheight checkbox-custom checkbox-inline highlight" data-initialize="checkbox">
                        <input class="sr-only" type="checkbox" name="visible" value="1" @if($pack->visible)checked="checked"@endif> Visible
                    </label>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <h5 class="nopad">Build Parameters</h5>
                <div class="well" style="margin-bottom:0">
                    <div class="row">
                        <div class="form-group col-md-3 col-xs-6">
                            <label class="control-label">Memory:</label>
                            <div class="input-group">
                                <input type="text" name="build_memory" class="form-control" value="{{ old('build_memory', $pack->build_memory) }}"/>
                                <span class="input-group-addon">MB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-xs-6">
                            <label class="control-label">Swap:</label>
                            <div class="input-group">
                                <input type="text" name="build_swap" class="form-control" value="{{ old('build_swap', $pack->build_swap) }}"/>
                                <span class="input-group-addon">MB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-xs-6">
                            <label class="control-label">CPU:</label>
                            <div class="input-group">
                                <input type="text" name="build_cpu" class="form-control" value="{{ old('build_cpu', $pack->build_cpu) }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-xs-6">
                            <label class="control-label">IO:</label>
                            <div class="input-group">
                                <input type="text" name="build_io" class="form-control" value="{{ old('build_io', $pack->build_io) }}"/>
                                <span class="input-group-addon">I/O</span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div>
                                <p class="text-muted"><small>If you would like to set limits on the build container you may do so above. Setting <code>memory</code>, <code>swap</code>, or <code>cpu</code> to <code>0</code> will allow unlimited resource utilization. IO must be in a range between <code>10</code> to <code>1000</code> and is a relative weighting to other container IO usage.</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Build Container:</label>
                            <div>
                                <input type="text" name="build_container" class="form-control" value="{{ old('build_container', $pack->build_container) }}"/>
                                <p class="text-muted"><small>Provide the docker container image that will be used to build this service pack. This container is <em>only</em> used if a build script is provided below.</small></p>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Build Script:</label>
                            <div id="build_script" style="height:200px">{{ $pack->build_script }}</div>
                            <textarea id="editor_contents" name="build_script" class="hidden"></textarea>
                            <p class="text-muted"><small>This script will be run inside the container if provided. You should use this script to download any additional dependencies or compile packages as necessary on the node. Your uploaded archive (if provided), will be available in <code>/input</code> as <code>archive.tar.gz</code> or as <code>archive.zip</code> depending on what format you uploaded as. Your completed pack should be saved as <code>package.tar.gz</code> in the <code>/output</code> directory (e.g. <code>/output/package.tar.gz</code>).</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <h5 class="nopad">Package Archive</h5>
                <div class="well" style="margin-bottom:0">
                    <div class="row">
                        <div class="form-group col-md-12">
                            @if(count($files) > 1)
                                <div class="alert alert-danger"><strong>Warning!</strong> Service packs should only contain a single pack archive in either <code>.zip</code> or <code>.tar.gz</code> format. We've detected more than one file for this pack.</div>
                            @endif
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Filename</th>
                                        <th>File Size</th>
                                        <th>SHA1 Hash</th>
                                        <th>Last Modified</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as &$file)
                                        <tr>
                                            <td>{{ basename($file) }}</td>
                                            <td><code>{{ Storage::size($file) }}</code> Bytes</td>
                                            <td><code>{{ sha1_file(storage_path('app/' . $file)) }}</code></td>
                                            <td>{{ Carbon::createFromTimestamp(Storage::lastModified($file))->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="text-muted"><small>If you wish to modify or upload a new file it should be uploaded to <code>{{ storage_path('app/packs/' . $pack->uuid) }}</code> as <code>archive.tar.gz</code>.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! csrf_field() !!}
                    <input type="submit" name="action_submit" class="btn btn-sm btn-primary" value="Edit Service Pack" />
                    <button type="submit" name="action_delete" class="pull-right btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
                    <a href="{{ route('admin.services.packs.export', $pack->id) }}"><button type="button" class="pull-right btn btn-sm btn-default" style="margin-right:10px;"><i class="fa fa-file"></i> Export</button></a>
                    <a href="{{ route('admin.services.packs.export', [ $pack->id, 'true' ]) }}"><button type="button" class="pull-right btn btn-sm btn-default" style="margin-right:10px;"><i class="fa fa-download"></i> Export with Files</button></a>
            </div>
        </div>
    </form>
</div>
{!! Theme::js('js/vendor/ace/ace.js') !!}
{!! Theme::js('js/vendor/ace/ext-modelist.js') !!}
<script type="text/javascript">
$(document).ready(function () {
    $('#sidebar_links').find("a[href='/admin/services/packs']").addClass('active');
    const Editor = ace.edit('build_script');

    Editor.setTheme('ace/theme/chrome');
    Editor.getSession().setUseWrapMode(true);
    Editor.setShowPrintMargin(false);
    Editor.getSession().setMode('ace/mode/sh');
    Editor.setOptions({
        minLines: 12,
        maxLines: Infinity
    });

    Editor.on('change', event => {
        $('#editor_contents').val(Editor.getValue());
    });
});
</script>
@endsection
