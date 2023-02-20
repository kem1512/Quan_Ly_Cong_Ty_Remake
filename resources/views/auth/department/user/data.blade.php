@if ($users->count() > 0)
    @foreach ($users as $user)
        <tr>
            <td class="w-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                </div>
            </td>
            <td>
                <span class="text-secondary text-xs font-weight-bold">{{ $user->fullname }}</span>
            </td>
            <td>
                <span class="text-secondary text-xs font-weight-bold">
                    <img src="{{ $user->img_url ?? 'https://cdn-icons-png.flaticon.com/512/147/147144.png' }}"
                        class="rounded-circle" style="width: 100px; height: 100px;" alt="">
                </span>
            </td>
            <td>
                <select class="form-control" name="position_id" id="position_id">
                    @foreach ($positions as $position)
                        <option {{ $position -> id == $user -> position_id ? 'selected' : '' }} value="{{ $position -> id }}" >{{ $position -> position }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control" name="nominee_id">
                    @foreach ($positions as $position)
                        @foreach ($position -> nominees as $nominee)
                            <option data-id="{{ $nominee -> position_id }}" value="{{ $nominee -> id }}" {{ $nominee -> id == $user -> nominee_id ? 'selected' : '' }} {{ $position -> id == $user -> position_id ? '' : 'hidden' }} >{{ $nominee -> nominees }}</option>
                        @endforeach
                    @endforeach
                </select>
            </td>
            <td>
                <span class="text-secondary text-xs font-weight-bold ps-2">{{ $user->phone ?? 'Chưa Có' }}</span>
            </td>
            <td>
                <span class="text-secondary text-xs font-weight-bold ps-2">{{ $user->gender ? 'Nam' : 'Nữ' }}</span>
            </td>
            <td>
                <button class="btn btn-danger staff m-0 update_user" data-id="{{ $user->id }}">Sửa</button>
                <button class="btn btn-danger staff m-0 delete_user" data-id="{{ $user->id }}">Xóa</button>
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="pt-4 border-0">
            {{ $users->links('pagination::bootstrap-4') }}
        </td>
    </tr>
@else
    <tr class="mt-2">
        <td class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center pt-5"
            colspan="7">
            Chưa Có Nhân Viên
        </td>
    </tr>
@endif
