<h1>Hi {{$volunteer->first_name}},</h1>

<p>
    du hast deine Daten erfolgreich geändert!
</p>

<h2>
    Hier kannst du sie noch einmal kontrollieren:
</h2>
<ul>
    <li>Vorname: {{$volunteer->first_name}}</li>
    <li>Nachname: {{$volunteer->last_name}}</li>
    <li>Email: {{$volunteer->email}}</li>
    <li>Mobile: {{$volunteer->mobile}}</li>
    <li>T-Shirt Größe: {{$volunteer->shirtSize->name}}</li>
</ul>

<h2>
    Hier sind die Schichten, für die du dich gemeldet hast:
</h2>
<ul>
    @foreach($assignments as $assignment)
        <li>{{$assignment->label}} (Aufgabe: {{$assignment->shift_name}}, Event: {{$assignment->event_name}}, Treffpunkt: {{$assignment->meeting_place}})</li>
    @endforeach
</ul>

<p>
    Dein Zugang bleibt weiterhin gültig.
</p>

<p>
    Wenn du weitere Fragen hast, lass sie unser <a href="mailto:organisation@orga-skhc.de">Orga-Team</a> wissen.
</p>

<p>
    Ansonsten sehen wir uns beim Rennen!
</p>

<p>
    Viele Grüße,<br>
    SKHC Orga
</p>
