<p class="italic font-bold">
    Bitte antworte nicht auf diese Email. Du möchtest uns schreiben, schreib an skhc@kulturtragwerk.de.
</p>

<h1>Hallo {{$volunteer->first_name}},</h1>

<p>
    deine Anmeldung war erfolgreich!
</p>

<p>
    Wir freuen uns dich als Helfer*in schon bald kennen zu lernen. Kurz vor dem Rennen mit der anschließenden Jubelfeier am 1. Mai werden wir mit dir in Kontakt treten. Dann gibt es detaillierte Informationen zu deiner Schicht.
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
    @foreach($volunteer->assignments as $shift)
        <li>{{$shift->label}} ({{$shift->event->name}})</li>
    @endforeach
</ul>

<p>
    Dein Helfer-Tshirt kannst du dir am Orgazelt an der Rennstrecke abholen! Falls du es nicht schaffst, schreib uns eine mail und wir vereinbaren ein Treffen.
</p>

<p>
    Du kannst deine Informationen jederzeit ändern oder löschen. Dazu kannst du <a href="{{ $createEditTokenRoute }}">hier einen Zugang generieren</a>.
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
