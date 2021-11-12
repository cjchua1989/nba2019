@if(!$data || !is_array($data) || !count($data))
    Sorry, no matching data was found
@else
    <style type="text/css">body{font:16px Roboto,Arial,Helvetica,Sans-serif}td,th{padding:4px 8px}th{background:#eee;font-weight:500}tr:nth-child(odd){background:#f4f4f4}</style>
    <table>
        <tr>
            @foreach($headings as $label)
                <th>{{ $label }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($data as $row)
                @foreach($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
            @endforeach
        </tr>
    </table>
@endif