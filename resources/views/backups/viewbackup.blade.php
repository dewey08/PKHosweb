<table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
    <thead>
        <tr class="text-uppercase">
            <th>ชื่อไฟล์</th>
            <th class="d-none d-sm-table-cell text-right" style="width: 120px;">ขนาด</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($files as $file)
        <tr>
            <td>
                <span class="font-w600">{{ $file['name'] }}</span>
            </td>
            <td class="d-none d-sm-table-cell text-right font-w500">
               {{-- {{ Storage::get(File::size($file)) }} --}}
               {{ $file['size'] }}
            </td>
            <td class="text-center text-nowrap font-w500">
                <a href="{{ url('backup/download/'.$file['name']) }}" title="{{ $file['name'] }}" class="download mr-1">
                    <i class="fas fa-download text-success"></i>
                </a>
                 |
                 <a href="{{ route('backup.delete', $file['name']) }}" title="{{ $file['name'] }}" class="ml-2 delete">
                    <i class="far fa-trash-alt"></i>
                 </a>
            </td>
        </tr>
@endforeach
    </tbody>
</table>
