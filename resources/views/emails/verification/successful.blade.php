<h1>Hi {{$volunteer->first_name}},</h1>

<p>
    deine Anmeldung war erfolgreich! Wir freuen uns schon dich kennen zu lernen.
</p>

<p>
    Hier sind die Schichten, für die du dich angemeldet hast.
</p>

<ul>
    @foreach($volunteer->assignments as $shift)
        <li>{{$shift->name}} ({{$shift->venue->name}})</li>
    @endforeach
</ul>

<p>
    Dein T-Shirt kannst du dir im //LOCATION// abholen.
</p>

<p>
    Du kannst deine Informationen jederzeit ändern oder löschen. Dazu kannst du <a href="{{ $createEditTokenRoute }}">hier einen Zugang generieren</a>.
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
