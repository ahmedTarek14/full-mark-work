@foreach ($users as $index => $user)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->status == 1 ? 'Activated' : 'Deactivated' }}</td>
        <td>{{ $user->created_at->format('d-m-Y') }}</td>
        <td>
            <div class="d-flex justify-content-center align-items-center">
                <a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn"
                    data-url="{{ route('admin.user.destroy', ['user' => $user->id]) }}"><i class="ti ti-trash"
                        style="margin-right:5px;"></i> Delete </a>
                @if ($user->status == 1)
                    <a class="btn btn-danger me-1 mb-2" title="Deactivated Account"
                        href="{{ route('admin.user.update_status', ['user' => $user->id]) }}"><i class="ti ti-minus"
                            style="margin-right:5px;"></i> Deactivated Account</a>
                @else
                    <a class="btn btn-success me-1 mb-2" title="Activated Account"
                        href="{{ route('admin.user.update_status', ['user' => $user->id]) }}"><i class="ti ti-check"
                            style="margin-right:5px;"></i> Activated Account</a>
                @endif


            </div>
        </td>
    </tr>
@endforeach
<tr class="text-center">
    <td colspan="12" align="center">
        {!! $users->links('pagination.custom') !!}
    </td>
</tr>
