<p class="italic font-bold">
    Bitte antworte nicht auf diese Email. Du möchtest uns schreiben, schreib an skhc@kulturtragwerk.de.
</p>

<h1>Hallo {{$volunteer->first_name}},</h1>

<p>
    du hast deine Daten erfolgreich geändert!
</p>

<p>
    Das sind deine persönlichen Daten. Bitte kontrolliere deine Mobilfunknummer, sodass wir dich erreichen können.
</p>

<ul>
    <li>Vorname: {{$volunteer->first_name}}</li>
    <li>Nachname: {{$volunteer->last_name}}</li>
    <li>Email: {{$volunteer->email}}</li>
    <li>Mobile: {{$volunteer->mobile}}</li>
    <li>T-Shirt Größe: {{$volunteer->shirtSize->name}}</li>
</ul>

<p>
    Hier sind die Schichten, für die du dich angemeldet hast.
</p>

<ul>
    @foreach($assignments as $assignment)
        <li>{{$assignment->label}} (Aufgabe: {{$assignment->shift_name}}, Event: {{$assignment->event_name}}, Treffpunkt: {{$assignment->meeting_place}})</li>
    @endforeach
</ul>

<p>
    Dein Helfer-Tshirt kannst du dir am Orgazelt an der Rennstrecke abholen! Falls du es nicht schaffst, schreib uns
    eine mail und wir vereinbaren ein Treffen.
</p>

<p>
    Du kannst deine Informationen jederzeit ändern oder löschen. Dazu kannst du <a href="{{ $createEditTokenRoute }}">hier
        einen Zugang generieren</a>.
</p>

<p>
    Wenn du weitere Fragen hast, kontaktiere uns - <a href="mailto:skhc@kulturtragwerk.de">skhc@kulturtragwerk.de</a>.
</p>

<p>
    Ansonsten sehen wir uns beim Rennen und spätestens zur Jubelfeier!
</p>

<p>
    Viele Grüße,<br>
    Das SKHC-Orgateam
</p>
