<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2">{{ Lang::get('backend.option') }}</th>
            <th width="70%">{{ Lang::get('backend.acl-set') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
        {{-- */ $mark = 0; /* --}}
        @foreach($menu['sub'] as $subMenu)
            <tr id="m{{ $menu->id }}">
                @if($mark == 0)
                <th rowspan="{{ count($menu['sub']) }}">
                    <input id="h_{{ $menu->id }}" type="checkbox" onclick="selectAllPermission(this, 'm{{ $menu->id }}', 'checkbox');" style="display:none;" />
                    <label class="px-single">
                        <input name="permission[]" type="checkbox" class="px" value="{{ $menu->id }}" @if(in_array($menu->id, $permission)) checked="checked" @endif /><span class="lbl"></span>
                    </label>
                    <a onclick="$('#h_{{ $menu->id }}').click();" href="javascript:void();" title="{{ Lang::get('backend.messages.select-all') }}" class="lbl">{{ $menu->name }}</a>
                </th>
                @endif
                <td>
                    <input id="h_{{ $subMenu->id }}" type="checkbox" onclick="selectAllPermission(this, 'm{{ $subMenu->id }}', 'checkbox')" style="display:none;" />
                    <label class="px-single">
                        <input name="permission[]" type="checkbox" class="px" value="{{ $subMenu->id }}" @if(in_array($subMenu->id, $permission)) checked="checked" @endif /><span class="lbl"></span>
                    </label>
                    <a onclick="$('#h_{{ $subMenu->id }}').click();" href="javascript:void();" class="lbl">{{ $subMenu->name }}</pa>
                </td>
                <td id="m{{ $subMenu->id }}">
                    @foreach($subMenu['sub'] as $grMenu)
                    <label class="checkbox-inline">
                        <input name="permission[]" type="checkbox" class="px" value="{{ $grMenu->id }}" @if(in_array($grMenu->id, $permission)) checked="checked" @endif /> <span class="lbl">{{ $grMenu->name }}</span>
                    </label>
                    @endforeach
                </td>
            </tr>
            {{-- */ $mark++; /* --}}
        @endforeach
    @endforeach
    <tr>
        <th class="text-left" colspan="2">
            <label class="checkbox-inline">
                <input type="checkbox" class="px" onclick="selectAllPermission(this, '', 'checkbox')" >
                <span class="lbl">{{ Lang::get('backend.all-select') }}</span>
            </label>
        </th>
        <td>
            <button class="btn btn-submit btn-primary" type="submit">{{ Lang::get('backend.save')}}</button>
            <button class="btn " onclick="javascript:history.go(-1);" type="button">{{ Lang::get('backend.return') }}</button>
        </td>
    </tr>
    </tbody>
</table>
