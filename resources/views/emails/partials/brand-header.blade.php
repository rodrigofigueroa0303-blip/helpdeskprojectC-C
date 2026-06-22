@php
    $logoUrl = rtrim(config('app.url'), '/') . '/images/Logocyccorreos.png';
@endphp

<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding: 32px 0 20px 0; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">
            <img src="{{ $logoUrl }}"
                 alt="C&C Consultores"
                 width="140"
                 style="display:block;margin:0 auto 12px auto;">

            <div style="font-size:22px;font-weight:700;color:#0D3B66;text-align:center;">
                Helpdesk C&amp;C
            </div>
        </td>
    </tr>
</table>
