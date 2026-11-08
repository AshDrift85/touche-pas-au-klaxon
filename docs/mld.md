# MLD : Touche pas au klaxon

Légende : clé primaire en **gras**, clé étrangère précédée de `#`.

```
AGENCY (**id**, name)

USER (**id**, last_name, first_name, phone, email, password, role)

TRIP (**id**, #departure_agency_id, #arrival_agency_id, departure_at, arrival_at,
      total_seats, available_seats, #author_id)
```

## Clés étrangères

| Table | Colonne | Référence | Suppression |
|-------|---------|-----------|-------------|
| TRIP | departure_agency_id | AGENCY(id) | interdite si un trajet l'utilise |
| TRIP | arrival_agency_id | AGENCY(id) | interdite si un trajet l'utilise |
| TRIP | author_id | USER(id) | en cascade (les trajets de l'utilisateur disparaissent) |

## Contraintes

- `AGENCY.name` : unique.
- `USER.email` : unique.
- `USER.role` : `user` ou `admin`.
- `TRIP` : `departure_agency_id <> arrival_agency_id`, `arrival_at > departure_at`,
  `available_seats <= total_seats` et `total_seats > 0`.

## Passage du MCD au MLD

- Les trois associations ont une cardinalité 1,1 côté TRIP : elles deviennent des clés étrangères
  dans TRIP (`author_id`, `departure_agency_id`, `arrival_agency_id`), sans table supplémentaire.
