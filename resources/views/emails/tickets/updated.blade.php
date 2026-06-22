<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    @include('emails.partials.brand-styles')
</head>
<body>
<div class="mail-wrapper">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="640" cellpadding="0" cellspacing="0" role="presentation" class="mail-container">
                    <tr>
                        <td>
                            @include('emails.partials.brand-header')
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-content">
                            <h1 class="mail-title">Actualizaci&oacute;n de ticket</h1>

                            {{-- L¨ªnea din¨¢mica que le mandas desde el controlador --}}
                            <p>{{ $messageLine }}</p>

                            <div class="meta-box" style="margin-top:16px;margin-bottom:16px;">
                                <p><span class="meta-label">Ticket:</span> {{ $ticket->subject }}</p>
                                <p><span class="meta-label">Estado actual:</span> {{ $ticket->status }}</p>
                                <p>
                                    <span class="meta-label">Asignado a:</span>
                                    @if($ticket->assignee)
                                        {{ $ticket->assignee->display_name }}
                                        @if($ticket->assignee->email)
                                            ({{ $ticket->assignee->email }})
                                        @endif
                                    @else
                                        Sin asignar
                                    @endif
                                </p>
                            </div>

                            <p style="margin: 20px 0;">
                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="btn-primary"
                                   target="_blank">Ver ticket</a>
                            </p>

                            <p style="margin-top:24px;">Gracias,<br>Helpdesk C&amp;C</p>
                        </td>
                    </tr>
                </table>

                <div class="mail-footer">
                    &copy; 2025 Helpdesk C&amp;C. Todos los derechos reservados.<br>
                    Este mensaje se genera automaticamente, por favor no responder directamente.
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

