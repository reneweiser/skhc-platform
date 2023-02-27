Hi {{$volunteer->first_name}},

deine Anmeldung war erfolgreich! Wir freuen uns schon dich kennen zu lernen.

Hier sind die Schichten, für die du dich angemeldet hast.

@foreach($volunteer->assignments as $shift)
    - {{$shift->name}} ({{$shift->venue->name}})

@endforeach

Dein T-Shirt kannst du dir da und da abholen.

Du kannst deine Informationen jederzeit ändern oder löschen. Dazu kannst du <a href="{{route('edit-token.create')}}">hier einen temporären Zugang generieren</a>.

Wenn du weitere Fragen hast, lass sie uns über info@skhc.de wissen.

Ansonsten sehen wir uns beim Rennen!

Viele Grüße,
SKHC Orga
